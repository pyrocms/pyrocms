<?php

use Pyro\Module\Templates\Model\TemplateEntryModel;

/**
 * Email Template Events Class
 *
 * @author      Stephen Cozart
 * @author		PyroCMS Dev Team
 * @package		PyroCMS\Core\Modules\Templates
 */
class Events_Templates
{
    protected $ci;

    protected $fallbacks = array();

    public function __construct()
    {
        $this->fallbacks = array(
            'comments'	=> array('comments'	=> 'email/comment'),
            'contact'	=> array('contact'	=> 'email/contact')
        );

        ci()->load->library('email');

        //register the email event
        Events::register('email', array($this, 'send_email'));

        // Clean up
        Events::register('module_uninstalled', array($this, 'remove_email_templates'));
        Events::register('module_disabled', array($this, 'remove_email_templates'));
    }

    /**
     *  Remove module email templates
     *
     *  object $module
     *  return void
     */
    public function remove_email_templates($module)
    {
        ci()->pdb->table('email_templates')->where('module', '=', $module->slug)->delete();
    }

    public function send_email($data = array())
    {
        $slug = $data['slug'];
        unset($data['slug']);

        // Get all email templates
        $templates = TemplateEntryModel::findBySlug($slug);

        // Make sure we have something to work with
        if ($templates) {
            $lang	   = isset($data['lang']) ? $data['lang'] : Settings::get('site_lang');
            $from	   = isset($data['from']) ? $data['from'] : Settings::get('server_email');
            $from_name = isset($data['name']) ? $data['name'] : null;
            $reply_to  = isset($data['reply-to']) ? $data['reply-to'] : $from;
            $to		   = isset($data['to']) ? $data['to'] : Settings::get('contact_email');

            // perhaps they've passed a pipe separated string, let's switch it to commas for CodeIgniter
            if ( ! is_array($to)) $to = str_replace('|', ',', $to);

            $subject = $templates->findByLang($lang)->subject;
            $subject = ci()->parser->parse_string($subject, $data, true);

            $body = $templates->findByLang($lang)->body ;
            $body = ci()->parser->parse_string($body, $data, true);

            ci()->email
                ->from($from, $from_name)
                ->reply_to($reply_to)
                ->to($to)
                ->subject($subject)
                ->message($body);

            // To send attachments simply pass an array of file paths in Events::trigger('email')
            // $data['attach'][] = /path/to/file.jpg
            // $data['attach'][] = /path/to/file.zip
            if (isset($data['attach'])) {
                foreach ($data['attach'] AS $attachment) {
                    ci()->email->attach($attachment);
                }
            }

            return (bool) ci()->email->send();
        }

        //return false if we can't find the necessary templates
        return false;
    }
}
