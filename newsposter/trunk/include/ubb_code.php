<?php
/* $Id$ */
//
// Authors: Frank Thomas <frank@thomas-alfeld.de>

// include all required files
require_once('misc.php');

/**
 * This file defines functions to handle UBB Code. This class has a poor
 * error handling for invalid ubb code.
 *
 * The following statements are replaced by this class:
 *
 *   [url]www.google.com[/url]  
 *          => <a href="http://www.google.com" target="new">www.google.com</a>
 *
 *   [url=http://www.google.com]Google[/url]
 *          => <a href="http://www.google.com" target="new">Google</a>
 *
 *   [email]frank@thomas-alfeld.de[/email]
 *          => <a href="mailto:frank@thomas-alfeld.de">frank@thomas-alfeld.de</a>
 *
 *   [i]italic[/i]
 *          => <i>italic</i>
 *
 *   [b]bold[/b]
 *          => <b>bold</b>
 *
 *   [u]underlined[/u]
 *          => <u>underlined</u>
 *
 *   [color=blue]blue text[/color]
 *          => <font color="blue">blue text</font>
 *
 *   [center]centered text[/center]
 *          => <center>centered text</center>
 *
 *   [small][/small]
 *          => <font size="-1"></font>
 *
 *   [big][/big]
 *          => <font size="+1"></font>
 *
 *   [img]http://host/picture.jpg[/img]
 *          => <img src="http://host/picture.jpg" title="http://host/picture.jpg" alt="" border="0" />
 * @brief	UBB Code replacement class
 */
class NP_UBB {

    var $text = '';

    /**
     * @access	public
     * @param	string	$orig_text
     * @return	string
     */
    function replace($orig_text)
    {
        $this->text = $orig_text;
        $depth = 10; // ubb code can be nested 10 times
                     // (for not detected/replaced codes)

        // valid_chars
        $v_chars = 'a-zA-Z.,:;=\/\?&!@% <>"0-9\+\-#';

        // pattern
        $pattern = "/\[(\w*)([$v_chars]*)\]([$v_chars]*)\[(\/\\1)\]/si";

        while( preg_match($pattern, $this->text) && $depth-- )
        {
            $this->text = preg_replace_callback($pattern,
			    array($this, '_replace_match'), $this->text);
        }
        return $this->text;
    }
    
    /**
     * @access	private
     * @param	string	$matches
     * @return	string	The replacement for the current match.
     */
    function _replace_match($matches)
    {
        // remove preceding =
        if (!empty($matches[2]))
            $matches[2] = substr($matches[2], 1);

        switch(strtolower($matches[1]))
        {
            case 'url':
                if (empty($matches[2]))
                    $matches[2] = $matches[3];

                $matches[2] = trim($matches[2]);

                if (strtolower(substr($matches[2], 0, 7)) != 'http://')
                    $matches[2] = 'http://' . $matches[2];

                $repl = sprintf('<a href="%s" target="new">%s</a>', $matches[2], $matches[3]);
                return $repl;
            
            case 'email':
                if (!strstr($matches[3], '@'))
                    return $matches[0];

                $repl = sprintf('<a href="mailto:%s">%s</a>', trim($matches[3]), $matches[3]);
                return $repl;

            case 'i': // italic
                $repl = "<i>$matches[3]</i>";
                return $repl;

            case 'b': // bold
                $repl = "<b>$matches[3]</b>";
                return $repl;

            case 'u': // underlined
                $repl = "<u>$matches[3]</u>";
                return $repl;

            case 'color':
                $repl = sprintf('<font color="%s">%s</font>', $matches[2], $matches[3]);
                return $repl;

            case 'center': // centered
                $repl = "<center>$matches[3]</center>";
                return $repl;

            case 'small':
                $repl = "<font size=\"-1\">$matches[3]</font>";
                return $repl;

            case 'big':
                $repl = "<font size=\"+1\">$matches[3]</font>";
                return $repl;

            case 'img':
                $repl = sprintf('<img src="%s" title="%s" alt="" border="0" />',
			$matches[3], $matches[3]);
                return $repl;
        }

        return $matches[0];
    }

}

?>
