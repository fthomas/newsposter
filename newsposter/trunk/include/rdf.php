<?php
/* $Id$ */
//
// Authors: Frank Thomas <frank@thomas-alfeld.de>

// include all required files
require_once('misc.php');
require_once($np_dir . '/config.php');

/**
 * This class creates RDF files for RSS (RDF Site Summary)
 * aggregation. For more information visit http://www.w3.org/RDF/.
 * RSS 1.0 specification is used for creating RSS files
 * (http://purl.org/rss/1.0/).
 * @brief	RSS file creation class
 */
class NP_RDF {

    var $rdf_file   = '';

    function NP_RDF()
    {
	$this->__construct();
    }
    
    function __construct()
    {
	global $cfg, $np_dir;	
    
	$this->rdf_file    = $np_dir . '/spool/news.rss';
	
			   
    
	if (! file_exists($this->rdf_file))
	    touch($this->rdf_file);
    }
    
    /**
     * @access	public
     */
    function create_rdf_file()
    {

	$this->rdf_header  = "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>\n"
	                   . "<rdf:RDF\n"
	                   . " xmlns:rdf=\"http://www.w3.org/1999/02/22-rdf-syntax-ns#\"\n"
	                   . " xmlns=\"http://purl.org/rss/1.0/\"\n"
	                   . ">\n\n"
			   . "\t<channel rdf:about="{$cfg['RDFPageURL']}">\n"
			   . "\t\t<title>{$cfg['PageTitle']}</title>\n"
			   . "\t\t<link>{$cfg['RDFPageURL']}</link>\n"
			   . "\t\t<description>{$cfg['RDFDescription']}</description>\n"
			   . "\t</channel>\n";
	$this->rdf_footer  = "</rdf:RDF>\n";

    }
}

?>