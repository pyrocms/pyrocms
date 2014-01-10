<?php namespace Pyro\Module\Blog;

use Pyro\Model\Eloquent;

class BlogCategoryModel extends Eloquent
{
	protected $table = 'blog_categories';

	public $timestamps = false;

	public function getTitleColumnValue()
	{
		return $this->title;
	}
}