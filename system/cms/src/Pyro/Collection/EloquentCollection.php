<?php namespace Pyro\Collection;

use Illuminate\Database\Eloquent\Collection;

class EloquentCollection extends Collection
{
	
	public function findByAttribute($value = null, $attribute = null)
 	{	
 		foreach ($this->items as $model)
 		{
			if(isset($model->{$attribute}) and $model->{$attribute} == $value)
 			{
 				return $model;
 			}
 		}
 		return false;
 	}
}