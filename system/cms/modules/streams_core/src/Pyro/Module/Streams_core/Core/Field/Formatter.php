<?php namespace Pyro\Module\Streams_core\Core\Field;

class Formatter
{
	// This will have similar methods to what the Row parser had to process rows and columns

	// This class will parse Entry model attributes / columns and process the them with thier corresponding
	// I want to aim for a structure in wich the formatter can figure out information about the model without the
	// need for the developer to pass to much arguments
	// 
	

	public static function formatEntries($models)
	{
		// returns the models with the attributes formated by their corresponding field type
	}

	public static function formatEntry($model)
	{
		// return the model with formatted attributes
		// explore the ability to return the attribute formatted by default but also have the option of returning the raw value
		// i.e. $model->attribute vs $model->attribute->getRaw()
		// 
		// or the ability to return the unformated models like
		// 
		// $query->getRaw()
		// 
	}

	public static function formatValue($value, $field)
	{

	}
	
}