<?php
/* $Id$ */
//
// Authors: Frank Thomas <frank@thomas-alfeld.de>

/**
 * According to RFC 977 (http://www.faqs.org/rfcs/rfc977.html)
 * this class communicates with a news server. It can post, cancel
 * and supersede newsposter's postings.
 */

require_once('misc.php');
require_once($np_dir . '/config.php');

class NP_Nntp {

    var $news_socket = '';

    /**
     *
     */
    function post($mesg)
    {
        if ($this->_connect() == FALSE)
            return FALSE;

        $this->_sendline('post');
        $this->_sendtext($mesg);

        return $this->_close();
    }

    /**
     *
     */
    function cancel($mesg, $msgid)
    {
    }

    /**
     *
     */
    function supersede($mesg, $msgid)
    {
    }

    /**
     * @access  private
     * @returns bool
     */
    function _connect()
    {
        global $cfg;

        $errno  = 0;
        $errstr = '';

        if (!$this->news_socket = fsockopen($cfg['NNTPServer'], $cfg['NNTPPort'],
                                  $errno, $errstr))
        {
            trigger_error("$errstr ($errno)");
            return FALSE;
        }

        // read greeting
        $intro  = fgets($this->news_socket);
        $status = substr($intro, 0, 3);

        if ($status == '201')
        {
            trigger_error('201 server ready - no posting allowed');
            return FALSE;
        }

        if (!empty($cfg['NNTPUser']))
        {
            $this->_sendline('authinfo user ' . $cfg['NNTPUser']);
            $this->_sendline('authinfo pass ' . $cfg['NNTPPassword']);
        }

        return TRUE;
    }

    /**
     * @access  private
     * @returns bool
     */
    function _close()
    {
        $this->_sendline('quit');
        return (fclose($this->news_socket)) ? TRUE : FALSE;
    }
    
    /**
     * @access  private
     * @param   string  $string
     * @param   bool    $is_text
     * @returns bool
     */
    function _sendline($string, $is_text = FALSE)
    {
        // $string should be shorter than 510 chars
        fwrite($this->news_socket, $string . "\r\n");

        // while posting a message, the server doesn't respond
        if ($is_text == TRUE)
            return TRUE;

        $response = fgets($this->news_socket);

        $status = substr($response, 0, 3);
        $text   = substr($response, 4);

        $error_codes = array(
            '400', // service discontinued
            '411', // no such news group
            '436', // transfer failed - try again later
            '437', // article rejected - do not try again.
            '440', // posting not allowed
            '441', // posting failed
            '500', // unknown command
            '501', // command syntax error
            '502', // access restriction or permission denied
            '503'  // program fault - command not performed
        );

        if (in_array($status, $error_codes))
        {
            trigger_error("$status $text ($string)");
            return FALSE;
        }

        return TRUE;
    }

    /**
     * @access  private
     * @param   string  $text
     * @param   string  $delimiter
     */
    function _sendtext($text, $delimiter = "\n")
    {
	// if \r is not in delimiter but at the end of each
	// line it will remain after the explode() statement
        if (!strstr($delimiter, "\r"))
            $text = str_replace("\r", '', $text);

        $lines   = explode($delimiter, $text);
        $n_lines = count($lines);

        foreach($lines as $key => $line)
        {   
            if ($key == $n_lines)
                $this->_sendline($line, FALSE);
            else
                $this->_sendline($line, TRUE);
        }

    }

}

?>
