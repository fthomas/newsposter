<?php
/* $Id$ */
//
// Authors: Frank Thomas <frank@thomas-alfeld.de>

// include all required files
require_once('misc.php');
require_once($np_dir . '/config.php');
require_once($cfg['StoreTypeFile']);

/**
 * This class creates RDF files for RSS (RDF Site Summary)
 * aggregation. For more information visit http://www.w3.org/RDF/.
 * RSS 1.0 specification is used for creating RSS files
 * (http://purl.org/rss/1.0/).
 * @brief	RSS file creation class
 */
class NP_RDF {

    var $rdf_file   = '';
    var $store_inst = 0;

    function NP_RDF()
    {
	$this->__construct();
    }
    
    function __construct()
    {
	global $np_dir;	
    
	// create global NP_Storing instance
	$this->store_inst = &new NP_Storing;
	$this->rdf_file   = $np_dir . '/spool/news.rss';
	
	if (! file_exists($this->rdf_file))
	    touch($this->rdf_file);
    }
    
    /**
     * @access	public
     * @return	bool
     * @todo	Change $rdf_link to a valid URL.
     */
    function create_rdf_file()
    {
	global $cfg;
    
	$items     = '';
	$rdf_items = '';
    
	if (($fp = fopen($this->rdf_file, 'w')) == FALSE)
	    return FALSE;
	
	if (! $cfg['RDFIncludeComments'])
	    $posts = $this->store_inst->get_all_news(0, $cfg['RDFMaxItems']);
	    
	else if ($cfg['RDFIncludeComments'])
	    $posts = $this->store_inst->get_all_postings(0, $cfg['RDFMaxItems']);
		
	// fill $itmes array and $rdf_items
	foreach($posts as $entry)
	{
	    $rdf_link   = $cfg['RDFLink'] . $entry['msgid'];
	    $rdf_items .= "\t\t\t\t<rdf:li resource=\"$rdf_link\" />\n";

	    // if body is longer than 400 chars, cut it after 400
	    // and append " ..."
	    if (strlen($entry['body']) > 400)
		$desc = substr($entry['body'], 0, 400) . " ...";
	    else
		$desc = $entry['body'];
	
	    $desc   = htmlentities(strip_tags($desc), ENT_COMPAT, 'UTF-8'); 
	    $pos    = count($items);
	    $items .= "\t<item rdf:about=\"$rdf_link\">\n"
	            . "\t\t<title>{$entry['subject']}</title>\n"
		    . "\t\t<link>$rdf_link</link>\n"
		    . "\t\t<description>$desc</description>\n"
	            . "\t</item>\n\n";
	}

	// create header of the RDF file
	$rdf_header = "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>\n"
	            . "<rdf:RDF\n"
	            . " xmlns:rdf=\"http://www.w3.org/1999/02/22-rdf-syntax-ns#\"\n"
	            . " xmlns=\"http://purl.org/rss/1.0/\"\n"
	            . ">\n\n"
		    . "\t<channel rdf:about=\"{$cfg['RDFPageURL']}\">\n"
		    . "\t\t<title>{$cfg['PageTitle']}</title>\n"
		    . "\t\t<link>{$cfg['RDFPageURL']}</link>\n"
		    . "\t\t<description>{$cfg['RDFDescription']}</description>\n"
		    . "\t\t<items>\n"
		    . "\t\t\t<rdf:Seq>\n";
	
	$rdf_cont   = sprintf("%s%s\t\t\t</rdf:Seq>\n\t\t</items>\n\t</channel>\n\n%s</rdf:RDF>\n",
			$rdf_header, $rdf_items, $items);
			
	fwrite($fp, $rdf_cont);
	return fclose($fp);
    }
}

?>