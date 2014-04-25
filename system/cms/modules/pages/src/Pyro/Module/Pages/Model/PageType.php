<?php namespace Pyro\Module\Pages\Model;

use Pyro\Model\Eloquent;

/**
 * Page type model
 *
 * @author      PyroCMS Dev Team
 * @package     PyroCMS\Core\Modules\Pages\Models
 * @link     http://docs.pyrocms.com/2.3/api/classes/Pyro.Module.Pages.Model.PageType.html
 */
class PageType extends Eloquent
{
    /**
     * Define the table name
     *
     * @var string
     */
    protected $table = 'page_types';

    /**
     * Cache minutes
     * @var int
     */
    public $cacheMinutes = 30;

    /**
     * The attributes that aren't mass assignable
     *
     * @var array
     */
    protected $guarded = array();

    /**
     * Disable updated_at and created_at on table
     *
     * @var boolean
     */
    public $timestamps = false;

    public function findBySlug($slug = null, array $columns = array('*'))
    {
        return static::where('slug', $slug)->take(1)->first($columns);
    }

    /**
     * Relationship: Page
     * @return Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function pages()
    {
        return $this->hasMany('Pyro\Module\Pages\Model\Page');
    }

    /**
     * Relationship: Stream
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function stream()
    {
        return $this->belongsTo('Pyro\Module\Streams\Stream\StreamModel');
    }

    /**
     * Slug exists
     */
    public static function slugExists($slug)
    {
        if ($exists = static::where('slug', $slug)->first()) {
            ci()->form_validation->set_message('_check_pt_slug', lang('page_types:_check_pt_slug_msg'));
        }

        return $exists;
    }

    /**
     * Validation callback to check the
     * page type slug. We want page type slugs
     * to be unique so we can use them as folder
     * names when saving as files.
     *
     * @param  string $slug - the page slug
     * @return bool
     */
    public static function _check_pt_slug($slug)
    {
        if (parent::count_by(array('slug' => $slug)) == 0) {
            return true;
        } else {
            $this->form_validation->set_message('_check_pt_slug', lang('page_types:_check_pt_slug_msg'));

            return false;
        }
    }

    // --------------------------------------------------------------------------

    /**
     * Place files for layout files.
     *
     *
     */
    public static function placePageLayoutFiles($input)
    {
        // Our folder path:
        $folder = ADDONPATH.'assets/page_types/'.$input['slug'];

        if (is_dir($folder)) {
            self::removePageLayoutFiles($input['slug']);
        } elseif ( ! mkdir($folder, 0777, true)) {
            return false;
        }

        ci()->load->helper('file');

        // Write our three files.
        write_file($folder.'/'.$input['slug'].'.html', $input['body']);
        write_file($folder.'/'.$input['slug'].'.js', $input['js']);
        write_file($folder.'/'.$input['slug'].'.css', $input['css']);
    }

    /**
     * Get page files
     *
     * If appropriate, gets the content from the
     * files instead of from the database.
     *
     * We also preserve the database copies for comparison
     * purposes.
     *
     */
    public function getPageTypeFilesForPage(&$page, $pt = false)
    {
        if ($page->save_as_files == 'y') {
            // We are getting this for a pt instead of a page,
            // then our vars are just a little different.
            $pt_slug_var = $pt ? 'slug' : 'page_type_slug';

            // Grab our files:

            $this->load->helper('file');

            $folder = ADDONPATH.'assets/page_types/'.$page->{$pt_slug_var}.'/';

            $page->db_originals = new stdClass();

            // Body
            $page->db_originals->body = $page->body;
            if (file_exists($folder.$page->{$pt_slug_var}.'.html')) {
                $page->body = read_file($folder.$page->{$pt_slug_var}.'.html');
            }

            // CSS/JS
            foreach (array('css', 'js') as $ext) {
                $page->db_originals->$ext = $page->$ext;
                if (file_exists($folder.$page->{$pt_slug_var}.'.'.$ext)) {
                    $page->$ext = read_file($folder.$page->{$pt_slug_var}.'.'.$ext);
                }
            }

            // Sync comparison.
            // If we are getting them for a page type list, we are going to compare our
            if ($pt) {
                $page->needs_sync = false;

                foreach (array('body', 'css', 'js') as $ext) {
                    // We only need to know one.
                    if (strcmp($page->db_originals->$ext, $page->$ext) != 0) {
                        $page->needs_sync = true;
                        break;
                    }
                }
            }
        }
    }

    /**
     * Delete a Page Type
     *
     * @param int $id ID of the page type
     * @param   bool [$delete_stream] Should we also delete the stream associated
     *                                     with the page type?
     * @return bool
     */
    public function delete($delete_stream = false)
    {
        // Are we going to delete the stream?
        if ($delete_stream and $this->stream) {
            $this->stream->delete();
        }

        $instance = new static;

        // If we are saving as files, we need to remove the page
        // layout files to keep things tidy.
        $instance->removePageLayoutFiles($this->slug, true);

        $instance->flushCacheCollection();

        // Delete the actual page entry.
        return parent::delete();
    }

    public static function streamInUseByMultipleTypes($stream_id = null)
    {
        return static::where('stream_id', $stream_id)->count() > 1;
    }

    // --------------------------------------------------------------------------

    /**
     * Rename page layout files + the folder.
     *
     * @param string $slug The slug to remove
     * @param bool [$remove_folder] Should we remove the folder as well as the files?
     * @return bool Was the operation successful?
     */
    public static function removePageLayoutFiles($slug, $remove_folder = false)
    {
        ci()->load->helper('file');

        $result = delete_files(ADDONPATH.'assets/page_types/'.$slug);

        $instance = new static;

        if ($remove_folder) {
            $result = $instance->removePageLayoutFolder($slug);
        }

        return $result;
    }

    // --------------------------------------------------------------------------

    /**
     * Remove page layout folder
     *
     * @param  string $slug The slug of the folder to remove.
     * @return mixed  null or bool result of rmdir
     */
    public static function removePageLayoutFolder($slug)
    {
        if (is_dir(ADDONPATH.'assets/page_types/'.$slug)) {
            return rmdir(ADDONPATH.'assets/page_types/'.$slug);
        }

        return null;
    }
}
