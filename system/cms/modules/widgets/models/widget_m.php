<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Model to handle widgets
 *
 * @author		Phil Sturgeon
 * @author		PyroCMS Dev Team
 * @package		PyroCMS\Core\Modules\Widgets\Models
 */
class Widget_m extends CI_Model
{
	public function find($id)
	{
		$instance = ci()->pdb
			->table('widget_areas wa')
			->select('w.id, w.slug, wi.id as instance_id, wi.title as instance_title, w.title, wi.widget_area_id, wa.slug as widget_area_slug, wi.options')
			->join('widget_instances wi', 'wa.id', '=', 'wi.widget_area_id')
			->join('widgets w', 'wi.widget_id', '=', 'w.id')
			->where('wi.id', $id)
			->take(1)
			->first();

		if ($instance) {
			$this->unserialize_fields($instance);
		}

		return $instance;
	}

	public function findByArea($slug)
	{
		$result = ci()->pdb
			->table('widget_areas')
			->select('widget_instances.id', 'widgets.slug', 'widget_instances.id as instance_id', 'widget_instances.title as instance_title', 'widgets.title', 'widget_instances.widget_area_id', 'widget_areas.slug as widget_area_slug', 'widget_instances.options')
			->join('widget_instances', 'widget_areas.id', '=', 'widget_instances.widget_area_id')
			->join('widgets', 'widget_instances.widget_id', '=', 'widgets.id')
			->where('widget_areas.slug', $slug)
			->orderBy('widget_instances.order')
			->get();

		if ($result) {
			array_map(array($this, 'unserialize_fields'), $result);
		}

		return $result;
	}

	public function findByAreas($slug = array())
	{
		if ( ! (is_array($slug) && $slug)) {
			return array();
		}

		$this->db
			->select('wi.id, w.slug, wi.id as instance_id, wi.title as instance_title, w.title, wi.widget_area_id, wa.slug as widget_area_slug, wi.options')
			->from('widget_areas wa')
			->join('widget_instances wi', 'wa.id', '=', 'wi.widget_area_id')
			->join('widgets w', 'wi.widget_id', '=', 'w.id')
			->where_in('wa.slug', $slug)
			->order_by('wi.order');

		$result = $this->db->get()->result();

		if ($result) {
			array_map(array($this, 'unserialize_fields'), $result);
		}

		return $result;
	}

	public function get_areas()
	{
		return $this->db->get('widget_areas')->result();
	}

	public function get_area_by($field, $id)
	{
		return $this->db->get_where('widget_areas', array($field => $id))->row();
	}

	public function get_widget_by($field, $id)
	{
		$result = $this->db->get_where('widgets', array($field => $id))->row();

		if ($result) {
			$this->unserialize_fields($result);
		}

		return $result;
	}

	public function unserialize_fields($obj)
	{
		foreach (array('title', 'description') as $field) {
			if (isset($obj->{$field})) {

				$_field = @unserialize($obj->{$field});

				if ($_field === false) {
					isset($obj->slug) && $this->widgets->reload_widget($obj->slug);
				} else {
					$obj->{$field} = is_array($_field)
						? isset($_field[CURRENT_LANGUAGE])
							? $_field[CURRENT_LANGUAGE] : $_field['en']
						: $_field;
				}
			}
		}

		return $obj;
	}

	public function get_all()
	{
		$result = parent::get_all();

		if ($result) {
			array_map(array($this, 'unserialize_fields'), $result);
		}

		return $result;
	}

	public function insert_widget($input = array())
	{
		// Merge defaults
		$input = array_merge(array(
			'enabled' => 1
		), (array) $input);

		$last_widget = $this->db
			->select('`order`')
			->order_by('`order`', 'desc')
			->limit(1)
			->get_where('widgets', array('enabled' => $input['enabled']))
			->row();

		$input['order'] = isset($last_widget->order) ? $last_widget->order + 1 : 1;

		return $this->db->insert('widgets', array(
			'title' 		=> serialize($input['title']),
			'slug' 			=> $input['slug'],
			'description' 	=> serialize($input['description']),
			'author' 		=> $input['author'],
			'website' 		=> $input['website'],
			'version' 		=> $input['version'],
			'enabled' 		=> $input['enabled'],
			'order' 		=> $input['order'],
			'updated_on'	=> time()
		));
	}

	public function update_widget($input)
	{
		if ( ! isset($input['slug'])) {
			return false;
		}

		return $this->db
			->where('slug', $input['slug'])
			->update('widgets', array(
				'title' 		=> serialize($input['title']),
				'slug' 			=> $input['slug'],
				'description' 	=> serialize($input['description']),
				'author' 		=> $input['author'],
				'website' 		=> $input['website'],
				'version' 		=> $input['version'],
				'updated_on'	=> time()
			));
	}

	public function update_widget_order($id, $order)
	{
		$this->db->where('id', $id);

		return $this->db->update('widgets', array(
        	'order' => (int) $order
		));
	}

	public function enable_widget($id = 0)
	{
		$this->db->where('id', $id);

		return $this->db->update('widgets', array(
        	'enabled' => 1
		));
	}

	public function disable_widget($id = 0)
	{
		$this->db->where('id', $id);

		return $this->db->update('widgets', array(
        	'enabled' => 0
		));
	}

	public function insert_area($input)
	{
		return $this->db->insert('widget_areas', array(
			'title' => $input['title'],
			'slug' 	=> $input['slug']
		));
	}

	public function update_area($input = array())
	{
		if (isset($input['id'])) {
			$this->db->where('id', $input['id']);
		} else {
			$this->db->where('slug', $input['area_slug']);
		}

		$this->db->update('widget_areas', array(
				'title'	=> $input['title'],
				'slug'	=> $input['slug']
			));

		$result = $this->db->affected_rows();

		return ($result > 0) ? true : false;
	}

	public function insert_instance($input)
	{
		$this->load->helper('date');

		$last_widget = $this->db
			->select('`order`')
			->order_by('`order`', 'desc')
			->limit(1)
			->get_where('widget_instances', array('widget_area_id' => $input['widget_area_id']))
			->row();

		$order = isset($last_widget->order) ? $last_widget->order + 1 : 1;

		return $this->db->insert('widget_instances', array(
			'title'				=> $input['title'],
			'widget_id'			=> $input['widget_id'],
			'widget_area_id'	=> $input['widget_area_id'],
			'options'			=> $input['options'],
			'order'				=> $order,
			'created_on'		=> time(),
		));
	}

	public function update_instance($instance_id, $input)
	{
		$this->db->where('id', $instance_id);

		return $this->db->update('widget_instances', array(
        	'title'				=> $input['title'],
			'widget_area_id'	=> $input['widget_area_id'],
			'options'			=> $input['options'],
			'updated_on'		=> time()
		));
	}

	public function update_instance_order($id, $order)
	{
		$this->db->where('id', $id);

		return $this->db->update('widget_instances', array(
        	'order' => (int) $order
		));
	}

	public function delete_widget($slug)
	{
		$widget = $this->db
			->select('id')
			->get_where('widgets', array('slug' => $slug))
			->row();

		if (isset($widget->id)) {
			$this->db->delete('widget_instances', array('widget_id' => $widget->id));
		}

		return $this->db->delete('widgets', array('slug' => $slug));
	}

	public function delete_area($id = 0)
	{
		if ( ! is_numeric($id)) {
			// Get the id for this area
			$area = $this->db
				->select('id')
				->get_where('widget_areas', array('slug' => $slug))
				->row();

			return $area ? $this->delete_area($area->id) : false;
		}

		// Delete widgets in that area
		$this->db->delete('widget_instances', array('widget_area_id' => $id));

		// Delete this area
		return $this->db->delete('widget_areas', array('id' => $id));
	}

	public function delete_instance($id)
	{
		return $this->db->delete('widget_instances', array('id' => $id));
	}
}
