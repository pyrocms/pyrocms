<?php namespace Pyro\Module\Blog;

use Pyro\Models\Eloquent;
use Pyro\FieldType\RelationshipInterface;

class BlogCategoryModel extends Eloquent implements RelationshipInterface
{
	/**
	 * The model table
	 * 
	 * @var string
	 */
	protected $table = 'blog_categories';

	/**
	 * Enable timestamps
	 * 
	 * @var boolean
	 */
	public $timestamps = false;

    /**
     * Cache minutes
     * 
     * @var int
     */
    public $cacheMinutes = 30;

    /**
     * Get the title column value
     * 
     * @return string
     */
	public function getFieldTypeRelationshipTitle()
	{
		return $this->title;
	}

	/**
	 * Get options
	 * 
	 * @return array
	 */
	public function getFieldTypeRelationshipOptions()
	{
		return $this->get(array('id', 'title'))->lists('title', 'id');
	}

	public function posts($take = null, $skip = null)
	{
		return $this->hasMany('Pyro\Module\Blog\BlogEntryModel', 'category_id')
			->published($take, $skip);
	}


}