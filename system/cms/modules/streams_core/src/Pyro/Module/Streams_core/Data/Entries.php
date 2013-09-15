<?php namespace Pyro\Module\Streams_core\Data;

use Closure;
use Pyro\Module\Streams_core\Core\Model;
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
	public static function getEntry($stream_slug, $stream_namespace = null, $id = null, $format = true, $plugin = true)
	{
		return Model\Entry::stream($stream_slug, $stream_namespace)->setFormat($format)->setPlugin($plugin)->find($id);
	}

	/**
	 * Get entries
	 * @param  string $stream_slug      
	 * @param  string $stream_namespace 
	 * @param  array  $params           
	 * @return array
	 */
	public static function getEntries($stream_slug = null, $stream_namespace = null, $params = array())
	{
		$model = Model\Entry::stream($stream_slug, $stream_namespace);

		$params['columns'] = ! empty($params['columns']) ? $params['columns'] : null; 

		return $model->get($params['columns']);
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
		$entry = static::getEntry($id, $stream_slug, $stream_namespace, $id);

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
			$entry = Model\Entry::stream($mixed, $stream_namespace);

			if ($id)
			{
				$entry = $model->setFormat(false)->find($id);
			}

			$form = $entry->newFormBuilder();
			
			$form->setDefaults($this->defaults);

			return $form->buildFields();
	}
}
