<?php
/* $Id$ */
//
// Authors: Frank Thomas <frank@thomas-alfeld.de>

// include all required files
require_once('misc.php');
require_once('constants.php');
require_once('date.php');
require_once($np_dir . '/config.php');
require_once($cfg['StoreTypeFile']);

/**
 * This class creates news feeds for aggregation. Currently the
 * following feed standards are supported:
 *     RSS 1.0  ( http://web.resource.org/rss/1.0/ )
 *     RSS 2.0  ( http://blogs.law.harvard.edu/tech/rss )
 *     Atom 0.3 ( http://www.mnot.net/drafts/draft-nottingham-atom-format-02.html )
 * @brief   News feeds creation class
 */
class NP_NewsFeeds {

    var $store_inst = 0;
    var $post_inst  = 0;
    
    var $feed_file  = array();
    var $feed_items = array();

    function NP_NewsFeeds()
    {
        $this->__construct();
    }
    
    function __construct()
    {
        global $np_dir;

        // create global NP_Storing / NP_Posting instance
        $this->store_inst = &new NP_Storing;
        $this->post_inst  = &new NP_Posting;

        $this->feed_file['rss10']  = $np_dir . '/spool/rss10.xml';
        $this->feed_file['rss20']  = $np_dir . '/spool/rss20.xml';
        $this->feed_file['atom03'] = $np_dir . '/spool/atom03.xml';
        
        // create all feed files
        foreach ($this->feed_file as $file)
        {
            if (! file_exists($file))
                touch($file);
        }
    }
    
    /**
     * Creates all supported feeds.
     * @access    public
     */
    function create_all()
    {
        // read all items from our database
        $this->get_items();
        
        $this->create_rss10();
        $this->create_rss20();
        $this->create_atom03();
    }
    
    /**
     * Uses NP_Storing and NP_Posting to get all content for the news
     * feeds. The feed specific data is stored in an array returned by
     * this function.
     * @access    public
     * @return    array    feed specific news items
     */
    function get_items()
    {
        global $cfg;
        
        if ($cfg['MaxFeedItems'] == 0)
            $max_items = NULL;
        else
            $max_items = $cfg['MaxFeedItems'];
        
        // get all postings
        if ($cfg['IncludeComments'])
            $posts = $this->store_inst->get_all_postings(0, $max_items);
        else
            $posts = $this->store_inst->get_all_news(0, $max_items);
    
        // initialize array
        $this->feed_items['rss10']['channel'] = '';
        $this->feed_items['rss10']['rdf']     = '';
        $this->feed_items['rss20']['channel'] = '';
        $this->feed_items['atom03']['feed']   = '';   
            
        foreach ($posts as $posting)
        {
            if ($cfg['StripSlashes'])
            {
                $posting['name']    = stripslashes($posting['name']); 
                $posting['mail']    = stripslashes($posting['mail']); 
                $posting['subject'] = stripslashes($posting['subject']);
                $posting['body']    = stripslashes($posting['body']);
            }
            
            $posting['msgid'] = prep_msgid($posting['msgid']);
            
            $link_view = $this->post_inst->get_posting_url($posting, VIEW);
            $link_form = $this->post_inst->get_posting_url($posting, FORM);
           
            $date_iso8601_1 = stamp2string($posting['stamp'], 13);
            $date_iso8601_2 = substr($date_iso8601_1, 0, 10);
            $date_rfc822    = stamp2string($posting['stamp'], 8);
            
            /* ---- RSS 1.0 ---- */
            
            $this->feed_items['rss10']['channel']
                .= "        <rdf:li rdf:resource=\"{$link}\" />\n";
            
            $this->feed_items['rss10']['rdf']
                .= "  <item rdf:about=\"{$link_view}\">\n"
                 . "    <title>{$posting['subject']}</title>\n"
                 . "    <link>{$link_view}</link>\n"
                 . "    <content:encoded>\n"
                 . "      <![CDATA[{$posting['body']}]]>\n"
                 . "    </content:encoded>\n"
                 . "    <dc:creator>{$posting['mail']} ({$posting['name']})</dc:creator>\n"
                 . "    <dc:date>{$date_iso8601_1}</dc:date>\n"
                 . "  </item>\n"
                 . "\n";
                        
            /* ---- RSS 2.0 ---- */
            
            $this->feed_items['rss20']['channel']
                .= "    <item>\n"
                .  "      <title>{$posting['subject']}</title>\n"
                .  "      <link>{$link_view}</link>\n"
                .  "      <description>\n"
                .  "        <![CDATA[{$posting['body']}]]>\n"
                .  "      </description>\n"
                .  "      <author>{$posting['mail']} ({$posting['name']})</author>\n"
                .  "      <comments>{$link_form}</comments>\n"
                .  "      <pubDate>{$date_rfc822}</pubDate>\n"
                .  "      <guid isPermaLink=\"true\">{$link_view}</guid>\n"
                .  "    </item>\n"
                .  "\n";
            
            /* ---- Atom 0.3 ----- */
            
            $this->feed_items['atom03']['feed']
                .= "  <entry>\n"
                .  "    <title>{$posting['subject']}</title>\n"
                .  "    <link rel=\"alternate\" type=\"text/html\" href=\"{$link_view}\" />\n"
                .  "    <author>\n"
                .  "      <name>{$posting['name']}</name>\n"
                .  "      <email>{$posting['mail']}</email>\n"
                .  "    </author>\n"
                .  "    <id>tag:newsposter.webhop.org,{$date_iso8601_2}:{$posting['msgid']}</id>\n"
                .  "    <modified>{$date_iso8601_1}</modified>\n"
                .  "    <issued>{$date_iso8601_1}</issued>\n"
                .  "    <content type=\"text/html\" mode=\"escaped\">\n"
                .  "      <![CDATA[{$posting['body']}]]>\n"
                .  "    </content>\n"
                .  "  </entry>\n"
                .  "\n";
        }
    }
    
    /**
     * Creates RSS 1.0 news feed
     * @access    public
     * @return    bool
     */
    function create_rss10()
    {
        global $cfg;

        $content = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n"
                 . "<rdf:RDF\n"
                 . "  xmlns:rdf=\"http://www.w3.org/1999/02/22-rdf-syntax-ns#\"\n"
                 . "  xmlns:dc=\"http://purl.org/dc/elements/1.1/\"\n"
                 . "  xmlns:content=\"http://purl.org/rss/1.0/modules/content/\"\n"
                 . "  xmlns=\"http://purl.org/rss/1.0/\">\n"
                 . "\n"
                 . "  <channel rdf:about=\"{$cfg['PageURL']}\">\n"
                 . "    <title>{$cfg['PageTitle']}</title>\n"
                 . "    <link>{$cfg['PageURL']}</link>\n"
                 . "    <description>{$cfg['Description']}</description>\n"
                 . "\n"
                 . "    <items>\n"
                 . "      <rdf:Seq>\n"
                 .          $this->feed_items['rss10']['channel']
                 . "      </rdf:Seq>\n"
                 . "    </items>\n"
                 . "  </channel>\n"
                 . "\n"
                 .    $this->feed_items['rss10']['rdf']
                 . "</rdf:RDF>\n";
        
        // write RSS 1.0 file
        if (($fp = fopen($this->feed_file['rss10'], 'w')) == FALSE)
            return FALSE;
        fwrite($fp, $content);
        
        return fclose($fp);
    }
    
    /**
     * Creates RSS 2.0 news feed
     * @access    public
     * @return    bool
     */
    function create_rss20()
    {
        global $cfg;
        
        $now_rfc822  = my_date(8);
        
        $content = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n"
                 . "<rss version=\"2.0\">\n"
                 . "  <channel>\n"
                 . "    <title>{$cfg['PageTitle']}</title>\n"
                 . "    <link>{$cfg['PageURL']}</link>\n"
                 . "    <description>{$cfg['Description']}</description>\n"
                 . "    <lastBuildDate>{$now_rfc822}</lastBuildDate>\n"
                 . "    <generator>". COMB_NAME ."</generator>\n"
                 . "    <docs>http://blogs.law.harvard.edu/tech/rss</docs>\n"
                 . "\n"
                 .      $this->feed_items['rss20']['channel']
                 . "  </channel>\n"
                 . "</rss>\n";
    
        // write RSS 2.0 file
        if (($fp = fopen($this->feed_file['rss20'], 'w')) == FALSE)
            return FALSE;     
        fwrite($fp, $content);
        
        return fclose($fp);
    }
    
    /**
     * Creates Atom 0.3 news feed
     * @access    public
     * @return    bool
     */    
    function create_atom03()
    {
        global $cfg;
        
        $now_iso8601 = my_date(13);
        
        $content = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n"
                 . "<feed version=\"0.3\" xmlns=\"http://purl.org/atom/ns#\" xml:lang=\"{$cfg['Language']}\">\n"
                 . "  <title>{$cfg['PageTitle']}</title>\n"
                 . "  <link rel=\"alternate\" type=\"text/html\" href=\"{$cfg['PageURL']}\" />\n"
                 . "  <tagline>{$cfg['Description']}</tagline>\n"
                 . "  <generator url=\"http://newsposter.webhop.org/\" version=\"" .VERSION. "\">Newsposter</generator>\n"
                 . "  <modified>{$now_iso8601}</modified>\n"
                 . "\n"
                 .    $this->feed_items['atom03']['feed']
                 . "</feed>\n";
    
        // write Atom 0.3 file
        if (($fp = fopen($this->feed_file['atom03'], 'w')) == FALSE)
            return FALSE;     
        fwrite($fp, $content);
        
        return fclose($fp);   
    }
}

?>
