<?php namespace Pyro\Module\Streams_core\Cp;

// The CP driver is broken down into more logical classes

use Closure;
use Pyro\Module\Streams_core\Core\Model;
use Pyro\Module\Streams_core\Core\Support\AbstractCp;

class Fields extends AbstractCp
{
	public static function table($stream_slug, $namespace = null)
	{
		$instance = static::instance(__function__);

		$instance->namespace = $namespace;

		return $instance;
	}

	public static function namespaceTable($namespace = null)
	{
		$instance = static::instance(__function__);

		$instance->namespace = $namespace;

		return $instance;
	}

	protected function renderTable()
	{
		$this->data['buttons'] = $this->buttons;

		// -------------------------------------
		// Get fields and create pagination if necessary
		// -------------------------------------

		if (is_numeric($this->pagination))
		{	
			$this->data['fields'] = Model\Field::getManyByNamespace($this->namespace, $pagination, $offset, $this->skips);

			$this->data['pagination'] = create_pagination(
											$pagination_uri,
											ci()->fields_m->count_fields($namespace),
											$pagination, // Limit per page
											$page_uri // URI segment
										);
		}
		else
		{
			$this->data['fields'] = Model\Field::getManyByNamespace($this->namespace, false, 0, $this->skips);

			$this->data['pagination'] = null;
		}

		// Allow view to inherit custom 'Add Field' uri
		$this->data['add_uri'] = $this->add_uri;
		
		// -------------------------------------
		// Build Pages
		// -------------------------------------

		$table = ci()->load->view('admin/partials/streams/fields', $this->data, true);
		
		if ($this->view_override)
		{
			// Hooray, we are building the template ourself.
			ci()->template->build('admin/partials/blank_section', array('content' => $table));
		}
		else
		{
			// Otherwise, we are returning the table
			return $table;
		}
	}

	protected function renderNamespaceTable()
	{
		$this->data['buttons'] = $this->buttons;

		// -------------------------------------
		// Get fields and create pagination if necessary
		// -------------------------------------

		if (is_numeric($this->pagination))
		{	
			$this->data['fields'] = Model\Field::getManyByNamespace($this->namespace, $pagination, $offset, $this->skips);

			$this->data['pagination'] = create_pagination(
											$pagination_uri,
											ci()->fields_m->count_fields($namespace),
											$pagination, // Limit per page
											$page_uri // URI segment
										);
		}
		else
		{
			$this->data['fields'] = Model\Field::getManyByNamespace($this->namespace, false, 0, $this->skips);

			$this->data['pagination'] = null;
		}

		// Allow view to inherit custom 'Add Field' uri
		$this->data['add_uri'] = $this->add_uri;
		
		// -------------------------------------
		// Build Pages
		// -------------------------------------

		$table = ci()->load->view('admin/partials/streams/fields', $this->data, true);
		
		if ($this->view_override)
		{
			// Hooray, we are building the template ourself.
			ci()->template->build('admin/partials/blank_section', array('content' => $table));
		}
		else
		{
			// Otherwise, we are returning the table
			return $table;
		}
	}

	public static form($id)
	{
		return static::instance(__function__);
	}

	protected function renderForm()
	{

	}

	public static assignmentForm($id)
	{
		return static::instance(__function__);
	}

	protected function renderAssignmentForm()
	{

	}
}