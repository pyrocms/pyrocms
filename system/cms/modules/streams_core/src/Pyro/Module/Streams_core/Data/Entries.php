<?php namespace Pyro\Module\Streams_core\Data;

use Closure;
use Pyro\Module\Streams_core\Core\Model\Entry;
use Pyro\Module\Streams_core\Core\Support\AbstractData;

class Entries extends AbstractData
{
	/**
	 * Get an entry
	 * @param  string  $stream_slug      
	 * @param  string  $stream_namespace 
	 * @param  integer  $id               
	 * @param  boolean $format           
	 * @param  boolean $plugin           
	 * @return object                    
	 */
	public static function getEntry($stream_slug, $stream_namespace = null, $id = null)
	{
		if ($entry = Entry::stream($stream_slug, $stream_namespace)->find($id) and $entry instanceof Entry)
		{
			return $entry->asString();
		}
		
		return null;
	}

	/**
	 * Get entries
	 * @param  string $stream_slug      
	 * @param  string $stream_namespace 
	 * @param  array  $params           
	 * @return array
	 */
	public static function getEntries($stream_slug = null, $stream_namespace = null)
	{
		$instance = static::instance(__FUNCTION__);

		$instance->model = Model\Entry::stream($stream_slug, $stream_namespace);
	}

	protected function triggerGetEntries()
	{
		$this->model->setViewOptions($this->data->view_options);

		return $this->query
			->enableAutoEagerLoading(true)
			->take($this->limit)
			->skip($this->offset)
			->get($this->select, $this->exclude);
	}

	/**
	 * Delete an entry
	 * @param  string $stream_slug      
	 * @param  string $stream_namespace 
	 * @param  integer $id               
	 * @return boolean                   
	 */
	public static function delete($stream_slug, $stream_namespace = null, $id = null)
	{
		$entry = static::getEntry($stream_slug, $stream_namespace, $id);

		return $entry->delete();
	}

	/**
	 * Get entry fields
	 * @param  string $stream_slug      
	 * @param  string $stream_namespace	
	 * @param  integer $id
	 * @return array
	 */
	public static function getEntryFields($stream_slug, $stream_namespace = null, $id = null)
	{
			$entry = Entry::stream($mixed, $stream_namespace);

			if ($id)
			{
				$entry = $model->setFormat(false)->find($id);
			}

			$form = $entry->newFormBuilder();
			
			$form->setDefaults($this->defaults);

			return $form->buildFields();
	}
}
