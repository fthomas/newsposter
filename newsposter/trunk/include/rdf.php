<?php
/* $Id$ */
//
// Authors: Frank Thomas <frank@thomas-alfeld.de>

// include all required files
require_once('misc.php');
require_once('date.php');
require_once($np_dir . '/config.php');
require_once($cfg['StoreTypeFile']);

/**
 * This class creates RDF files for RSS (RDF Site Summary)
 * aggregation. For more information visit http://www.w3.org/RDF/.
 * RSS 1.0 specification is used for creating RSS files
 * (http://purl.org/rss/1.0/).
 * @brief   RSS file creation class
 */
class NP_RDF {

    var $rdf_file   = '';
    var $store_inst = 0;
    var $post_inst  = 0;

    function NP_RDF()
    {
        $this->__construct();
    }
    
    function __construct()
    {
        global $np_dir;

        // create global NP_Storing / NP_Posting instance
        $this->store_inst = &new NP_Storing;
        $this->post_inst  = &new NP_Posting;

        $this->rdf_file   = $np_dir . '/spool/rss10.xml';

        if (! file_exists($this->rdf_file))
            touch($this->rdf_file);
    }
    
    /**
     * @access    public
     * @return    bool
     */
    function create_rdf_file()
    {
        global $cfg;
        
        if (($fp = fopen($this->rdf_file, 'w')) == FALSE)
            return FALSE;
    
        if ($cfg['RDFIncludeComments'] == TRUE)
            $posts = $this->store_inst->get_all_postings(0, $cfg['RDFMaxItems']);
        else
            $posts = $this->store_inst->get_all_news(0, $cfg['RDFMaxItems']);
        
        $items_channel  = '';
        $items_rdf      = '';
        
        // compose items
        foreach($posts as $posting)
        {
            // link to posting
            $link = $this->post_inst->get_sp_url($posting);
            
            // add item_ch
            $items_channel .= "        <rdf:li rdf:resource=\"{$link}\" />\n";

            // create ISO 8601 date
            $date = stamp2string($posting['stamp'], 13);
            
            // add item_rdf
            $items_rdf .= "  <item rdf:about=\"{$link}\">\n"
                        . "    <title>{$posting['subject']}</title>\n"
                        . "    <link>{$link}</link>\n"
                        . "    <content:encoded>\n"
                        . "      <![CDATA[{$posting['body']}]]>\n"
                        . "    </content:encoded>\n"
                        . "    <dc:date>{$date}</dc:date>\n"
                        . "  </item>\n\n";
        }

        // compose header of the RDF file
        $rdf_header = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n"
                    . "<rdf:RDF\n"
                    . "  xmlns:rdf=\"http://www.w3.org/1999/02/22-rdf-syntax-ns#\"\n"
                    . "  xmlns:dc=\"http://purl.org/dc/elements/1.1/\"\n"
                    . "  xmlns:content=\"http://purl.org/rss/1.0/modules/content/\"\n"
                    . "  xmlns=\"http://purl.org/rss/1.0/\">\n"
                    . "\n"
                    . "  <channel rdf:about=\"{$cfg['PageURL']}\">\n"
                    . "    <title>{$cfg['PageTitle']}</title>\n"
                    . "    <link>{$cfg['PageURL']}</link>\n"
                    . "    <description>{$cfg['RDFDescription']}</description>\n\n"
                    . "    <items>\n"
                    . "      <rdf:Seq>\n";

        // compose entire RDF file
        $rdf_cont   = $rdf_header . $items_channel
                    . "      </rdf:Seq>\n"
                    . "    </items>\n"
                    . "  </channel>\n\n"
                    . $items_rdf
                    . "</rdf:RDF>\n";
        
        fwrite($fp, $rdf_cont);
        
        return fclose($fp);
    }
}

?>
