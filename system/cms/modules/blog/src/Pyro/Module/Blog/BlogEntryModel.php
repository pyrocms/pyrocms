<?php namespace Pyro\Module\Blog;

use Pyro\Streams\Model\BlogsBlogEntryModel;

class BlogEntryModel extends BlogsBlogEntryModel
{

	protected $appends = array('url');

	public function findBySlug($slug)
	{

	}

	public static function getMutatorCache()
	{
		return static::$mutatorCache;
	}

	public function getUrlAttribute()
	{
		return site_url('blog/'.date('Y/m', strtotime($this->created_at)).'/'.$this->slug);
	}

	public static function findManyByCategoryId($categoryId = null, $take = null, $skip = null)
	{
		if (! $categoryId) return false;

		return static::published($take, $skip)
			->where('category_id', '=', $categoryId)
			->get();
	}

	public function scopeLive($query)
	{
		return $query->where('status', 'live');
	}

	public function scopePublished($query, $take = null, $skip = null)
	{
		return $query->live()
			->orderBy('created_at', 'DESC')
			->take($take)
			->skip($skip);
	}

}