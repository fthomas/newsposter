<?php
/* $Id$ */
//
// Authors: Frank Thomas <frank@thomas-alfeld.de>

require_once('misc.php');
require_once($np_dir . '/config.php');

require_once('constants.php');
require_once('posting.php');

/**
 * This class sends mail after a posting was written or
 * if somebody tried to access a restricted area. The newsletter
 * function has a less administrative purpose. These should
 * just be infos of new postings.
 * @brief    Mail and Newsletter handling class
 */
class NP_Mail {

    var $post_inst = 0;
    
    function NP_Mail()
    {
        $this->post_inst = &new NP_Posting;
    }

    /**
     * @access    public
     * @return    bool
     */
    function send_mail_error()
    {
        global $cfg, $lang;

        $addr      = $this->_get_host_addr();
        $sess_vars = $this->_get_session_vars();

        $body = "{$lang['mail_intro_error']}:\n"
              . "    {$lang['mail_ip']}: {$addr['ip']}\n"
              . "    {$lang['mail_hostname']}: {$addr['hostname']}\n"
              . "\n"
              . $sess_vars;

        return $this->_mail($cfg['EmailTo'], $lang['mail_subj_error'], $body);
    }
    
    /**
     * @access    public
     * @param     array    $posting
     * @return    bool
     */
    function send_mail_success($posting)
    {
        global $cfg, $lang;

        $addr = $this->_get_host_addr();
        $type = $this->post_inst->get_type($posting);

        if ($cfg['StripSlashes'])
        {
            $posting['name']    = stripslashes($posting['name']); 
            $posting['mail']    = stripslashes($posting['mail']); 
            $posting['subject'] = stripslashes($posting['subject']);
            $posting['body']    = stripslashes($posting['body']);
        }
        
        $body = sprintf("{$lang['mail_intro_success']}:\n", $type)
              . "    {$lang['mail_ip']}: {$addr['ip']}\n"
              . "    {$lang['mail_hostname']}: {$addr['hostname']}\n"
              . "\n"
              . "    {$lang['misc_name']}: {$posting['name']}\n"
              . "    {$lang['misc_mail']}: {$posting['mail']}\n"
              . "    {$lang['misc_subject']}: {$posting['subject']}\n"
              . "\n"
              . $posting['body'];

        return $this->_mail($cfg['EmailTo'], $lang['mail_subj_new'], $body);
    }
    
    /**
     * @access    public
     * @param     array    $posting
     * @return    bool
     */
    function send_newsletter($posting)
    {
        global $cfg, $lang;

        $type = $this->post_inst->get_type($posting);
        $link = $this->post_inst->get_posting_url($posting, VIEW);

        if ($cfg['StripSlashes'])
        {
            $posting['name']    = stripslashes($posting['name']); 
            $posting['mail']    = stripslashes($posting['mail']); 
            $posting['subject'] = stripslashes($posting['subject']);
            $posting['body']    = stripslashes($posting['body']);
        }
        
        $body = sprintf("{$lang['mail_intro_success']}:\n", $type)
              . "    {$lang['misc_name']}: {$posting['name']}\n"
              . "    {$lang['misc_subject']}: {$posting['subject']}\n"
              . "\n"
              . "    $link";

        return $this->_mail($cfg['NewsletterTo'], $lang['mail_subj_new'], $body, TRUE);
    }

    /**
     * @access    private
     * @param     string    $to     Comma seperated list of all recipients.
     * @param     string    $subject
     * @param     string    $body
     * @param     bool      $bcc    If it's true, we use BCC instead of To.
     *                              To is $cfg['EmailFrom'] then. 
     * @return    bool
     */
    function _mail($to, $subject, $body, $bcc = FALSE)
    {
        global $cfg;

        if (empty($to))
            return TRUE;

        if ($bcc)
        {
            $bcc_header = "Bcc: $to\n";
            $to         = $cfg['EmailFrom'];
        }
        else
            $bcc_header = '';
        
        $headers = "From: {$cfg['EmailFrom']}\n"
                 . "Content-Type: text/plain; charset=utf-8\n"
                 . "Content-Transfer-Encoding: 8bit\n"
                 . USER_AGENT ."\n"
                 . $bcc_header;
    
        return mail($to, $subject, $body, $headers);
    }
     
    /**
     * @access    private
     * @return    array
     */
    function _get_host_addr()
    {
        global $lang;

        // get ip address and hostname
        if (isset($_SERVER['REMOTE_ADDR']))
        {
            $addr['ip']       = $_SERVER['REMOTE_ADDR'];
            $addr['hostname'] = gethostbyaddr($addr['ip']);
        } 
        else
        {
            $addr['ip']       = $lang['misc_unknown'];
            $addr['hostname'] = $lang['misc_unknown'];
        }
        
        return $addr;
    }
    
    /**
     *
     */
    function _get_session_vars()
    {
        ob_start();

        if (isset($_SESSION['NP']))
            print_r($_SESSION['NP']);

        $session_vars = ob_get_contents();
        
        ob_end_clean();
        
        return $session_vars;
    }
    
}

?>