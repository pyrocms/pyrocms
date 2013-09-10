<?php namespace Pyro\Module\Streams_core\Data;

use Closure;
use Pyro\Module\Streams_core\Core\Model;
use Pyro\Module\Streams_core\Core\Support\AbstractData;

class Entries extends AbstractData
{

	public static function getEntry($stream_slug, $stream_namespace = null, $id = null, $format = true, $plugin = true)
	{
		return Model\Entry::stream($stream_slug, $stream_namespace)->setFormat($format)->setPlugin($plugin)->findEntry($id);
	}

	public static function getEntries($stream_slug = null, $stream_namespace = null, $params = array())
	{
		$model = Model\Entry::stream($stream_slug, $stream_namespace);

		$params['columns'] = ! empty($params['columns']) ? $params['columns'] : null; 

		return $model->get($params['columns']);
	}

	public static function delete($stream_slug, $stream_namespace = null, $id = null)
	{
		$entry = static::getEntry($id, $stream_slug, $stream_namespace, $id);

		return $entry->delete();
	}

	public static function getEntryFields($stream_slug, $stream_namespace = null, $id = null)
	{
			$model = Model\Entry::stream($mixed, $stream_namespace);

			if ($id)
			{
				$entry = $model->findEntry($id)->unformatted();
			}
			else
			{
				$entry = $model;
			}

			$form = $entry->newFormBuilder();
			
			$form->setDefaults($this->defaults);

			return $form->buildFields();
	}

}