<?php namespace Pyro\Module\Blog;

use Pyro\Model\Eloquent;
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
     * Fillable attributes
     *
     * @var array
     */
    protected $fillable = array('title', 'slug');

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

    protected $orderByColumn = 'title';


    /**
     * Find a category based on the slug value
     *
     * @return string
     */
    public function findBySlug($slug)
    {
        return $this->where('slug', '=', $slug)->first();
    }

    public static function findMany($limit = 0, $offset = null, $fresh = false)
    {
        $query = static::orderBy('title');

        if ($limit) {
            $query
                ->take($limit)
                ->offset($offset);
        }

        return $query->fresh($fresh)->get();
    }

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
    public function getFieldTypeRelationshipOptions($type)
    {
        return $this->get(array('id', 'title'))->lists('title', 'id');
    }

    public function posts()
    {
        return $this->hasMany('Pyro\Module\Blog\BlogEntryModel', 'category_id');
    }

    public function publishedPosts($take = null, $skip = null)
    {
        return $this->hasMany('Pyro\Module\Blog\BlogEntryModel', 'category_id')
            ->published($take, $skip);
    }

    public function getFieldTypeRelationshipSearchFields()
    {
        return array('title');
    }

    public function getFieldTypeRelationshipValueField()
    {
        return 'title';
    }
}
