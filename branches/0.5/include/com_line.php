<?php
/* $Id: com_line.php 32 2002-12-29 23:07:27Z anonymous $ */
//
// Authors: Frank Thomas <frank@thomas-alfeld.de>

// include all required files 
require_once('misc.php');

/**
 * A small class for commandline interaction. Can read and write
 * from/to std streams. 
 * @brief	Command line interaction class
 */
class NP_ComLine {

    var $stream_in;
    var $stream_out;
    var $stream_err;

    // Zend Engine 2 is comming...
    function NP_ComLine()
    {
        $this->__construct();
    }

    /**
     * @access	private
     */
    function __construct()
    {
        if ( !($this->stream_in  = fopen('php://stdin',  'r')) )
            trigger_error('Cannot open stdin stream');

        if ( !($this->stream_out = fopen('php://stdout', 'w')) )
            trigger_error('Cannot open stdout stream');
            
        if ( !($this->stream_err = fopen('php://stderr', 'w')) )
            trigger_error('Cannot open stderr stream');
    }

    /**
     * @access	public
     * @param	string	$mesg
     * @return	void
     */
    function write_ln($mesg)
    {
        fputs($this->stream_out, $mesg);
        fflush($this->stream_out);
    }

    /**
     * @access	public
     * @param	string	$err_mesg
     * @return	void
     */
    function write_err($err_mesg)
    {
        fputs($this->stream_err, $err_mesg);
        exit();
    }

    /**
     * @access	public
     * @return	string
     */
    function read_ln()
    {
        $input = trim(fgets($this->stream_in));
        return $input;
    }

}

?>
