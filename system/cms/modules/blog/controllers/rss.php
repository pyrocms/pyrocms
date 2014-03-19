<?php defined('BASEPATH') or exit('No direct script access allowed');

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

    public function __construct()
    {
        parent::__construct();
        $this->load->model('blog_m');
        $this->load->helper('xml');
        $this->load->helper('date');
        $this->lang->load('blog');
        $this->load->driver('Streams');

        // We are going to get all the categories so we can
        // easily access them later when processing posts.
        $cates = $this->db->get('blog_categories')->result_array();
        foreach ($cates as $cate)
        {
            $this->categories[$cate['id']] = $cate;
        }

        // Set the output content type
        $this->output->set_content_type('application/rss+xml');
    }

    public function index()
    {
        $posts = $this->streams->entries->get_entries(array(
            'stream'        => 'blog',
            'namespace'     => 'blogs',
            'limit'         => Settings::get('rss_feed_items'),
            'where'         => "`status` = 'live'",
        ));

        $html = $this->load->view('rss', $this->_build_feed($posts, $this->lang->line('blog:rss_name_suffix')), true);

        echo $this->parser->parse_string($html, $posts);
    }

    public function category($slug = '')
    {
        $this->load->model('blog_categories_m');

        if ( ! $category = $this->blog_categories_m->get_by('slug', $slug))
        {
            redirect('blog/rss/all.rss');
        }

        $posts = $this->streams->entries->get_entries(array(
            'stream'        => 'blog',
            'namespace'     => 'blogs',
            'limit'         => Settings::get('rss_feed_items'),
            'where'         => "`status` = 'live' AND `category_id` = '{$category->id}'",
        ));

        $html = $this->load->view('rss', $this->_build_feed($posts, $category->title.$this->lang->line('blog:rss_category_suffix')), true);

        echo $this->parser->parse_string($html, $posts);
    }

    public function _build_feed($posts = array(), $suffix = '')
    {
        $entries = $posts['entries'];

        $data = new stdClass();
        $data->rss = new stdClass();

        $data->rss->encoding = $this->config->item('charset');
        $data->rss->feed_name = Settings::get('site_name').' '.$suffix;
        $data->rss->feed_url = base_url();
        $data->rss->page_description = sprintf($this->lang->line('blog:rss_posts_title'), Settings::get('site_name'));
        $data->rss->page_language = 'en-gb';
        $data->rss->creator_email = Settings::get('contact_email');

        if ( ! empty($entries))
        {
            foreach ($entries as $row)
            {
                $row = (object) $row;
                $row->created_at = human_to_unix($row->created_at);
                $row->link = site_url('blog/'.date('Y/m', $row->created_at).'/'.$row->slug);
                $row->created_at = date(DATE_RSS, $row->created_at);

                $intro = (isset($row->intro)) ? $row->intro : $row->body;

                $item = array(
                    //'author' => $row->author,
                    'title' => xml_convert($row->title),
                    'link' => $row->link,
                    'guid' => $row->link,
                    'description' => $intro,
                    'date' => $row->created_at,
                    'category' => ''
                );

                // Set the category if it exists
                if (isset($this->categories[$row->category_id]))
                {
                    $item['category'] = $this->categories[$row->category_id]['title'];
                }
                else
                {
                    log_message('debug', 'A blog category with the ID `'. $row->category_id .'` doesn\'t exist for post `'. $row->id . '`');
                }

                $data->rss->items[] = (object)$item;
            }
        }

        return $data;
    }
}
