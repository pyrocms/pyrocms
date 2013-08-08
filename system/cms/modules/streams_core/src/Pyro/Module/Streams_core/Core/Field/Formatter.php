<?php namespace Pyro\Module\Streams_core\Core\Field;

class Formatter
{
	// This will have similar methods to what the Row parser had to process rows and columns

	// This class will parse Entry model attributes / columns and process the them with thier corresponding
	// I want to aim for a structure in wich the formatter can figure out information about the model without the
	// need for the developer to pass to much arguments
	// 

	protected $entries = array();

	protected $model;

	public function __construct(array $entries = array())
	{
		$this->entries = $entries;
	}

	public function formatEntries(array $entries = array())
	{	
		// returns the models with the attributes formated by their corresponding field type
		$formatted = array();

		foreach ($entries as $entry)
		{
			$formatted[] = $this->formatEntry($entry);
		}

		return $formatted;
	}

	// return the model with formatted attributes
	// explore the ability to return the attribute formatted by default but also have the option of returning the raw value
	// i.e. $model->attribute vs $model->attribute->getRaw()
	// 
	// or the ability to return the unformated models like
	// 
	// $query->getRaw()
	public function formatEntry(\Pyro\Module\Streams_core\Core\Model\Entry $entry = null)
	{
		$assignments = $this->model->getStream()->assignments;

		// Replicate the model to keep the original intact
		$clone = $entry->replicate();

		foreach (array_keys($clone->getAttributes()) as $field_slug)
		{
			if ($field = $assignments->getFields()->findBySlug($field_slug))
			{
				// If there exist a field for the corresponding attribute, format it
				$clone->{$field_slug} = $this->formatAttribute($entry->{$field_slug}, $field);
			}
			else
			{
				// If not replicate the raw value
				$clone->{$field_slug} = $entry->{$field_slug};
			}
		};

		// Restore the primary key to the replicated model
		$clone->{$this->model->getKeyName()} = $entry->{$this->model->getKeyName()};

		return $clone;
	}

	public static function formatAttribute($value, $field)
	{
		// Here we will load out field type and return the formatted value
		return 'hello';
	}
	
	public function getFormattedEntries()
	{
		return $this->formatEntries($this->entries);
	}

	public function setModel(\Pyro\Module\Streams_core\Core\Model\Entry $model = null)
	{
		$this->model = $model;
	}

}