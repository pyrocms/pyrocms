<?php namespace Pyro\Module\Streams\Support;

// Separate email stuff into its on class

class Email
{
    /**
     * Send Email
     *
     * Sends emails for a single notify group.
     *
     * @access	public
     * @param	string 	$notify 	a or b
     * @param	int 	$entry_id 	the entry id
     * @param	string 	$method 	edit or new
     * @param	obj 	$stream 	the stream
     * @return	void
     */
    public function send_email($notify, $entry_id, $method, $stream)
    {
        extract($notify);

        // We need a notify to and a template, or
        // else we can't do anything. Everything else
        // can be substituted with a default value.
        if ( ! isset($notify) and ! $notify) return null;
        if ( ! isset($template) and ! $template) return null;

        // -------------------------------------
        // Get e-mails. Forget if there are none
        // -------------------------------------

        $emails = explode('|', $notify);

        if (empty($emails)) return null;

        // For each email, we can have an email value, or
        // we take it from the form's post values.
        foreach ($emails as $key => $piece) {
            $emails[$key] = $this->_process_email_address($piece);
        }

        // -------------------------------------
        // Parse Email Template
        // -------------------------------------
        // Get the email template from
        // the database and create some
        // special vars to pass off.
        // -------------------------------------

        $layout = $this->CI->db
                            ->limit(1)
                            ->where('slug', $template)
                            ->get('email_templates')
                            ->row();

        if ( ! $layout) return null;

        // -------------------------------------
        // Get some basic sender data
        // -------------------------------------
        // These are for use in the email template.
        // -------------------------------------

        $this->CI->load->library('user_agent');

        $data = array(
            'sender_ip'			=> $this->CI->input->ip_address(),
            'sender_os'			=> $this->CI->agent->platform(),
            'sender_agent'		=> $this->CI->agent->agent_string()
        );

        // -------------------------------------
        // Get the entry to pass to the template.
        // -------------------------------------

        $params = array(
                'id'			=> $entry_id,
                'stream'		=> $stream->stream_slug);

        $rows = $this->CI->row_m->get_rows($params, $this->CI->streams_m->get_stream_fields($stream->id), $stream);

        $data['entry']			= $rows['rows'];

        // -------------------------------------
        // Parse the body and subject
        // -------------------------------------

        $layout->body = html_entity_decode($this->CI->parser->parse_string(str_replace(array('&quot;', '&#39;'), array('"', "'"), $layout->body), $data, true));

        $layout->subject = html_entity_decode($this->CI->parser->parse_string(str_replace(array('&quot;', '&#39;'), array('"', "'"), $layout->subject), $data, true));

        // -------------------------------------
        // Set From
        // -------------------------------------
        // We accept an email address from or
        // a name/email separated by a pipe (|).
        // -------------------------------------

        $this->CI->load->library('Email');

        if (isset($from) and $from) {
            $email_pieces = explode('|', $from);

            // For two segments we process it as email_address|name
            if (count($email_pieces) == 2) {
                $email_address 	= $this->_process_email_address($email_pieces[0]);
                $name 			= ($this->CI->input->post($email_pieces[1])) ?
                                        $this->CI->input->post($email_pieces[1]) : $email_pieces[1];

                $this->CI->email->from($email_address, $name);
            } else {
                $this->CI->email->from($this->_process_email_address($email_pieces[0]));
            }
        } else {
            // Hmm. No from address. We'll just use the site setting.
            $this->CI->email->from(Settings::get('server_email'), Settings::get('site_name'));
        }

        // -------------------------------------
        // Set Email Data
        // -------------------------------------

        $this->CI->email->to($emails);
        $this->CI->email->subject($layout->subject);
        $this->CI->email->message($layout->body);

        // -------------------------------------
        // Send, Log & Clear
        // -------------------------------------

        $return = $this->CI->email->send();

        $this->CI->email->clear();

        return $return;
    }

    // --------------------------------------------------------------------------

    /**
     * Process an email address - if it is not
     * an email address, pull it from post data.
     *
     * @access	private
     * @param	email
     * @return	string
     */
    private function _process_email_address($email)
    {
        if (strpos($email, '@') === false and $this->CI->input->post($email)) {
            return $this->CI->input->post($email);
        }

        return $email;
    }
}
