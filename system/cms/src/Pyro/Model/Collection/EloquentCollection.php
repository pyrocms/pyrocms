<?php namespace Pyro\Model\Collection;

use Illuminate\Database\Eloquent\Collection;

class EloquentCollection extends Collection
{
	protected $model;

	public function findByAttribute($value = null, $attribute = null)
 	{	
 		foreach ($this->items as $model)
 		{
			if($model->{$attribute} == $value)
 			{
 				return $model;
 			}
 		}
 		return false;
 	}

	public function setModel( \Pyro\Model\Eloquent $model = null)
	{
		$this->model = $model;

		return $this;
	}

	public function getModel()
	{
		return $this->model;
	}

}