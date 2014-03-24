<?php defined('BASEPATH') or exit('No direct script access allowed');

use Pyro\Module\Blog\BlogCategoryModel;
use Pyro\Module\Blog\BlogEntryModel;

/**
 * @author  PyroCMS Dev Team
 * @package PyroCMS\Core\Modules\Blog\Controllers
 */
class Rss extends Public_Controller
{
    /**
     * All of the blog categories
     * @var array
     */
    protected $categories = array();

    /**
     * Construct
     */
    public function __construct()
    {
        parent::__construct();
        $this->lang->load('blog');

        $this->blogs = new BlogEntryModel;
        $this->categories = new BlogCategoryModel;

        // Set the output content type
        $this->output->set_content_type('application/rss+xml');
    }

    /**
     * Index
     * Show recent posts for all categories
     *
     * @return void
     */
    public function index()
    {
        $posts = $this->blogs->findManyPosts(Settings::get('records_per_page'), 0, 'category');

        $rss = $this->buildFeed($posts, $this->lang->line('blog:rss_name_suffix'));

        $this->load->view('rss', array('rss' => $rss));
    }

    /**
     * Category
     * Show recent posts for all categories
     *
     * @param string $slug Category slug
     * @return void
     */
    public function category($slug = '')
    {
        $category = $this->categories->findBySlug($slug);

        if (! $category) {
            show_404();
        }

        $posts = $category->publishedPosts;

        $rss = $this->buildFeed($posts, $category->title.$this->lang->line('blog:rss_category_suffix'));

        $this->load->view('rss', array('rss' => $rss));
    }

    protected function buildFeed($posts = array(), $suffix = '')
    {
        $rss = new stdClass();

        $rss->encoding = $this->config->item('charset');
        $rss->feed_name = Settings::get('site_name').' '.$suffix;
        $rss->feed_url = base_url();
        $rss->page_description = sprintf($this->lang->line('blog:rss_posts_title'), Settings::get('site_name'));
        $rss->page_language = 'en-gb';
        $rss->creator_email = Settings::get('contact_email');

        if (! empty($posts)) {

            $items = array();
            foreach ($posts as $post) {
                $post->link = site_url('blog/'.($post->created_at->format('Y/m')).'/'.$post->slug);

                $intro = $post->intro ?: $post->body;

                $items[] = (object) array(
                    //'author' => $post->author,
                    'title' => htmlentities($post->title),
                    'link' => $post->link,
                    'guid' => $post->link,
                    'description' => $intro,
                    'date' => $post->created_at,
                    'category' => $post->category ? $post->category->title : '',
                );
            }

            $rss->items = $items;
        }

        return $rss;
    }
}
