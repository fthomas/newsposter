<?php
/* $Id$ */
//
// Authors: Frank Thomas <frank@thomas-alfeld.de>

/**
 * A small class for commandline interaction. Can read and write
 * from/to std streams. 
 */

// include all required files 
require_once('misc.php');

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
     * @access  private
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
     * @param   string  $mesg
     * @access  public
     * @returns void
     */
    function write_ln($mesg)
    {
        fputs($this->stream_out, $mesg);
        fflush($this->stream_out);
    }

    /**
     * @param   string  $err_mesg
     * @access  public
     * @returns void
     */
    function write_err($err_mesg)
    {
        fputs($this->stream_err, $err_mesg);
        exit();
    }

    /**
     * @access  public
     * @returns string
     */
    function read_ln()
    {
        $input = trim(fgets($this->stream_in));
        return $input;
    }

}

?>
