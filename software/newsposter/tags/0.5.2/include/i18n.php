<?php
/* $Id$ */
//
// Authors: Frank Thomas <frank@thomas-alfeld.de>
//
// language_accept() and language_negotiate() taken from:
// http://www.zend.com/codex.php?id=616&single=1

// include all required files
require_once('constants.php');
require_once('misc.php');
require_once($np_dir . '/config.php');

/**
 * This class adds internationalization (i18n) and content negotiation
 * to Newsposter.
 * @brief    Internationalization class
 */
class NP_I18N {

    var $avail_lang = array('de', 'en');
    var $pref_lang  = '';

    function NP_I18N()
    {
        $this->__construct();
    }

    function __construct()
    {
        global $cfg;
        
        // set default language
        $this->pref_lang = $cfg['Language'];
        
        // content negotiation is disabled
        if (!$cfg['ContentNegotiation'])
        {
            $this->include_translation();
            return;
        }
        
        // negotiate language
        $this->pref_lang = $this->_language_accept($this->avail_lang);
        
        // $_GET['np_lang'] overrides negotiated language
        $_GET['np_lang'] = strtolower($_GET['np_lang']);
        
        if (isset($_GET['np_lang']) && preg_match('/\w{2}/', $_GET['np_lang'])
            && in_array($_GET['np_lang'], $this->avail_lang))
        {    
            $this->pref_lang = $_GET['np_lang'];
        }
        
        // fallback to default language
        if (empty($this->pref_lang))
            $this->pref_lang = $cfg['Language'];
        
        $this->include_translation();
        $cfg['Locale'] = array($this->pref_lang, $cfg['Locale']);
    }

    /**
     * Includes the language file of the user-preferred language.
     * @access    public 
     */
    function include_translation()
    {
        global $np_dir;
        
        $filename = $np_dir . '/lang/' . $this->pref_lang . '.php';

        // include language file
        if (is_readable($filename))
            require_once($filename);
        
        // add $lang variable to global namespace
        $GLOBALS['lang'] = $lang;
    }
    

    /**
     * Tries to include a localized version of $cfg['IncludeHeader']
     * or $cfg['IncludeFooter'] if ContentNegotiation is enabled.
     * @access    public
     * @param     int    $type    HEADER or FOOTER
     * @return    bool
     */
    function include_frame($type=0)
    {
        global $cfg;
    
        switch ($type)
        {
            case HEADER:
                $frame = $cfg['IncludeHeader'];
                break;
            
            case FOOTER:
                $frame = $cfg['IncludeFooter'];
                break;
            
            default:
                $frame = '';
        }
        
        if (empty($frame))
            return TRUE;
    
        if (!$cfg['ContentNegotiation'])
        {
            if (is_readable($frame))
            {
                include_once($frame);
                return TRUE;
            }
            else 
                return FALSE;
        }
        
        // assume filename has language extension (header.inc.de)
        if ( preg_match('/.*\.\w{2}$/', $frame) )
        {
            $frame_localized  = substr($frame, 0, strlen($frame)-3);
            $frame_localized .= "." . $this->pref_lang;
        }
        else
            $frame_localized = $frame .".". $this->pref_lang;

        if (is_readable($frame_localized))
        {
            include_once($frame_localized);
        }
        else
        {
            if (is_readable($frame))
            {
                include_once($frame);
                return TRUE;
            }
            else 
                return FALSE;
        }
        
        return TRUE;
    }

    /**
     * Takes a list of languages the current document is 
     * available in as a parameter, and returns either a 
     * language that the browser and server have in common, 
     * or an empty string if no match was found.
     * @access   private
     * @param    array    $accept    array of language codes to accept 
     * @return   string   negotiated language code or ''
     */
    function _language_accept($accept='')
    {  
        $lang = split(',', $_SERVER['HTTP_ACCEPT_LANGUAGE']); 
 
        // parse http_accept_language header 
        foreach($lang as $i=>$value)
        { 
            $value    = split(';', $value); 
            $lang[$i] = trim($value[0]);
        } 
 
        return $this->_language_negotiate($lang, $accept);
    }

    /**
     * Finds a matching language between the two arrays. Tries 
     * to match whole language code, then first two characters 
     * (ie. 'en-us', 'en').
     * @access   private 
     * @param    array    $ask_lang     array of language codes the
     *                                  browser wants
     * @param    array    $accept_lang  array of language codes this
     *                                  document is available in 
     * @return   string   language code or ''
     */
    function _language_negotiate($ask_lang, $accept_lang)
    { 
        if (!(is_array($ask_lang) && is_array($accept_lang)))
            return ''; 
 
        // if it exists exactly, or just the first two characters 
        foreach($ask_lang as $lang)
        { 
            if (in_array($lang, $accept_lang))
                return $lang; 
        
            $short_lang = substr($lang, 0, 2); 
        
            if (in_array($short_lang, $accept_lang))
                return $short_lang; 
        } 
 
        return ''; 
    }
}

?>