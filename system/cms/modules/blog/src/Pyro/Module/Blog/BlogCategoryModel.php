<?php namespace Pyro\Module\Blog;

use Pyro\Model\Eloquent;

class BlogCategoryModel extends Eloquent
{
	/**
	 * The model table
	 * @var string
	 */
	protected $table = 'blog_categories';

	/**
	 * Enable timestamps
	 * @var boolean
	 */
	public $timestamps = false;

    /**
     * Cache minutes
     * @var int
     */
    public $cacheMinutes = 30;

    /**
     * Get the title column value
     */
	public function getTitleColumnValue()
	{
		return $this->title;
	}
}