<?php

use Pyro\Module\Blog\BlogCategoryModel;
use Pyro\Module\Blog\BlogEntryModel;
use Pyro\Module\Keywords\Model\Applied;
use Pyro\Module\Keywords\Model\Keyword;

/**
 * Public Blog module controller
 *
 * @author  PyroCMS Dev Team
 * @package PyroCMS\Core\Modules\Blog\Controllers
 */
class Blog extends Public_Controller
{
    /**
     * Every time this controller is called should:
     * - load the blog and blog_categories models.
     * - load the keywords library.
     * - load the blog language file.
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->library(array('keywords/keywords'));
        $this->lang->load('blog');

        $this->blogs = new BlogEntryModel;
        $this->categories = new BlogCategoryModel;
    }

    /**
     * Index
     *
     * List out the blog posts.
     *
     * URIs such as `blog/page/x` also route here.
     */
    public function index()
    {
        // Total posts
        $total = $this->blogs->live()->count();

        // Skip
        if (ci()->input->get('page')) {
            $skip = (ci()->input->get('page') - 1) * Settings::get('records_per_page');
        } else {
            $skip = 0;
        }

        // Get the latest blog posts
        $posts = $this->blogs
            ->findManyPosts(Settings::get('records_per_page'), $skip, 'category')
            ->getPresenter('plugin');

        // Create pagination
        $pagination = create_pagination(
            'blog',
            $total,
            Settings::get('records_per_page')
        );

        // Set meta description based on post titles
        $meta = $this->postsMetadata($posts);

        // Go!
        $this->template
            ->title($this->module_details['name'])
            ->set_breadcrumb(lang('blog:blog_title'))
            ->set_metadata('og:title', $this->module_details['name'], 'og')
            ->set_metadata('og:type', 'blog', 'og')
            ->set_metadata('og:url', current_url(), 'og')
            ->set_metadata('og:description', $meta['description'], 'og')
            ->set_metadata('description', $meta['description'])
            ->set_metadata('keywords', $meta['keywords'])
            ->set('posts', $posts->isEmpty() ? false : $posts)
            ->set('pagination', $pagination['links'])
            ->build('posts');
    }

    /**
     * Lists the posts in a specific category.
     *
     * @param string $slug The slug of the category.
     */
    public function category($slug = '')
    {
        $slug or redirect('blog');

        // Get category data
        $category = $this->categories->findBySlug($slug);

        if (! $category) {
            show_404();
        }

        // Total posts
        $total = $this->blogs
            ->where('status', '=', 'live')
            ->where('category_id', '=', $category->id)
            ->count();

        // Skip
        if (ci()->input->get('page')) {
            $skip = (ci()->input->get('page')-1) * Settings::get('records_per_page');
        } else {
            $skip = 0;
        }

        // Get the latest blog posts
        $posts = $category
            ->publishedPosts(Settings::get('records_per_page'), $skip)
            ->get()
            ->getPresenter('plugin');

        // Create pagination
        $pagination = create_pagination(
            'blog',
            $total,
            Settings::get('records_per_page')
        );

        // Set meta description based on post titles
        $meta = $this->postsMetadata($posts);

        // Build the page
        $this->template->title($this->module_details['name'], $category->title)
            ->set_metadata('description', $category->title.'. '.$meta['description'])
            ->set_metadata('keywords', $category->title)
            ->set_breadcrumb(lang('blog:blog_title'), 'blog')
            ->set_breadcrumb($category->title)
            ->set('pagination', $pagination['links'])
			->set('posts', $posts->isEmpty() ? false : $posts)
            ->set('category', (array) $category)
            ->build('posts');
    }

    /**
     * Lists the posts in a specific year/month.
     *
     * @param null|string $year  The year to show the posts for.
     * @param string      $month The month to show the posts for.
     */
    public function archive($year = null, $month = '01')
    {
        $year or $year = date('Y');
        $month_date = new DateTime($year.'-'.$month.'-01');

        // Total posts
        $total = $this->blogs
            ->where('status', '=', 'live')
            ->whereYear('created_at', '=', $year)
            ->whereMonth('created_at', '=', $month)
            ->count();

        // Skip
        if (ci()->input->get('page')) {
            $skip = (ci()->input->get('page')-1)*Settings::get('records_per_page');
        } else {
            $skip = 0;
        }

        // Get the latest blog posts
        $posts = $this->blogs
            ->where('status', '=', 'live')
            ->whereYear('created_at', '=', $year)
            ->whereMonth('created_at', '=', $month)
            ->orderBy('created_at', 'DESC')
            ->take(Settings::get('records_per_page'))
            ->skip($skip)
            ->get()
            ->getPresenter('string');

        // Create pagination
        $pagination = create_pagination(
            'blog',
            $total,
            Settings::get('records_per_page')
        );

        // Set meta description based on post titles
        $meta = $this->postsMetadata($posts);

        // Process
        $posts = $this->processPosts($posts);

        $this->template
            ->title($month_year, lang('blog:archive_title'), lang('blog:blog_title'))
            ->set_metadata('description', $month_year.'. '.$meta['description'])
            ->set_metadata('keywords', $month_year.', '.$meta['keywords'])
            ->set_breadcrumb(lang('blog:blog_title'), 'blog')
            ->set_breadcrumb(lang('blog:archive_title').': '.format_date($month_date->format('U'), lang('blog:archive_date_format')))
            ->set('pagination', $pagination['links'])
            ->set('posts', $posts->isEmpty() ? false : $posts)
            ->set('month_year', $month_year)
            ->build('archive');
    }

    /**
     * View a post
     *
     * @param string $slug The slug of the blog post.
     */
    public function view($slug)
    {
        // We need a slug to make this work.
        if (! $slug) {
            redirect('blog');
        }

        // Get the latest blog posts
        $post = $this->blogs->findBySlug($slug);

        if (! is_object(ci()->current_user) or ! ci()->current_user->isSuperUser()) {
            if (! $post or $post['status'] !== 'live') {
                redirect('blog');
            }
        }

        $this->singleView($post);
    }

    /**
     * Preview a post
     *
     * @param string $hash the preview_hash of post
     */
    public function preview($hash = '')
    {
        if (! $hash) {
            redirect('blog');
        }

        $post = $this->blogs->findByPreviewHash($hash);
       
        if (! $post) {
            redirect('blog');
        }

        if ($post->status === 'live') {
            redirect('blog/'.($post->created_at->format('Y/m')).'/'.$post->slug);
        }

        // Set index nofollow to attempt to avoid search engine indexing
        $this->template->set_metadata('index', 'nofollow');

        $this->singleView($post);
    }

    /**
     * Tagged Posts
     *
     * Displays blog posts tagged with a
     * tag (pulled from the URI)
     *
     * @param string $tag
     */
    public function tagged($tag = '')
    {
        // decode encoded cyrillic characters
        $tag = rawurldecode($tag) or redirect('blog');

        $tag = Keyword::whereName($tag)->first();
        $ids = Applied::whereEntryType(get_class($this->blogs))->get()->lists('entry_id');
        $ids = $ids + array(0);

        // Total posts
        $total = $this->blogs->whereIn('id', $ids)->count();

        // Skip
        if (ci()->input->get('page')) {
            $skip = (ci()->input->get('page')-1)*Settings::get('records_per_page');
        } else {
            $skip = 0;
        }

        // Get the latest blog posts
        $posts = $this->blogs
            ->where('status', '=', 'live')
            ->whereIn('id', $ids)
            ->orderBy('created_at', 'DESC')
            ->take(Settings::get('records_per_page'))
            ->skip($skip)
            ->get()
            ->getPresenter();

        // Create pagination
        $pagination = create_pagination(
            'blog',
            $total,
            Settings::get('records_per_page')
        );

        $pagination['links'] = str_replace('-1', '1', $pagination['links']);

        // Set meta description based on post titles
        $meta = $this->postsMetadata($posts);

        if ($tag) {
            $name = $tag->name;
        } else {
            $name = '';
        }


        // Build the page
        $this->template
            ->title($this->module_details['name'], lang('blog:tagged_label').': '.$name)
            ->set_metadata('description', lang('blog:tagged_label').': '.$name.'. '.$meta['description'])
            ->set_metadata('keywords', $name)
            ->set_breadcrumb(lang('blog:blog_title'), 'blog')
            ->set_breadcrumb(lang('blog:tagged_label').': '.$name)
            ->set('pagination', $pagination['links'])
            ->set('posts', $posts->isEmpty() ? false : $posts)
            ->set('tag', $tag)
            ->build('posts');
    }

    /**
     * Posts Metadata
     *
     * @param array $posts
     *
     * @return array keywords and description
     */
    protected function postsMetadata($posts = array())
    {
        $keywords = array();
        $description = array();

        // Loop through posts and use titles for meta description
        if (! empty($posts)) {
            foreach ($posts as $post) {
                if (isset($post->category->title) and ! in_array($post->category->title, $keywords)) {
                    $keywords[] = $post->category->title;
                }

                $description[] = $post->title;
            }
        }

        return array(
            'keywords' => implode(', ', $keywords),
            'description' => implode(', ', $description)
        );
    }

    /**
     * Single View
     *
     * Generate a page for viewing a single
     * blog post.
     *
     * @param 	array $post The post to view
     * @return 	void
     */
    protected function singleView($post)
    {
        $this->session->set_flashdata(array('referrer' => $this->uri->uri_string()));

        $this->template->set_breadcrumb(lang('blog:blog_title'), 'blog');

        if ($post->category_id > 0) {
            // Get the category. We'll just do it ourselves
            // since we need an array.
            if ($category = $post->category) {
                $this->template->set_breadcrumb($category->title, 'blog/category/'.$category->slug);

                // Set category OG metadata
                $this->template->set_metadata('article:section', $category->title, 'og');
            }
        }

        // Add in OG keywords
        foreach (explode(',', $post['keywords']) as $keyword) {
            $this->template->set_metadata('article:tag', $keyword, 'og');
        }

        // If comments are enabled, go fetch them all
        if (Settings::get('enable_comments')) {
            // Load Comments so we can work out what to do with them
            $this->load->library('comments/comments', array(
                'entry_id' => $post['id'],
                'entry_title' => $post['title'],
                'module' => 'blog',
                'singular' => 'blog:post',
                'plural' => 'blog:posts',
            ));

            // Comments enabled can be 'no', 'always', or a strtotime compatable difference string, so "2 weeks"
            $this->template->set('form_display', (
                $post->comments_enabled === 'always' or
                    ($post->comments_enabled !== 'no' and time() < strtotime('+'.$post->comments_enabled, strtotime($post->created_at)))
            ));
        }

        $this->template
            ->title($post['title'], lang('blog:blog_title'))
            ->set_metadata('og:type', 'article', 'og')
            ->set_metadata('og:url', current_url(), 'og')
            ->set_metadata('og:title', $post['title'], 'og')
            ->set_metadata('og:site_name', Settings::get('site_name'), 'og')
            ->set_metadata('og:description', $post['intro'], 'og')
            ->set_metadata('article:published_time', date(DATE_ISO8601, strtotime($post->created_at)), 'og')
            ->set_metadata('article:modified_time', date(DATE_ISO8601, strtotime($post['updated_at'])), 'og')
            ->set_metadata('description', strip_tags($post['intro']))
            ->set_metadata('keywords', $post['keywords'])
            ->set_breadcrumb($post['title'])
            ->set('post', array($post))
            ->build('view');
    }
}
