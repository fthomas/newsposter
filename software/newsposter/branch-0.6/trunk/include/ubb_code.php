<?php
/* $Id$
 *
 * This file is part of Newsposter
 * Copyright (C) 2001-2004 by Frank S. Thomas <frank@thomas-alfeld.de>
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License 
 * along with this program; if not, write to the
 * Free Software Foundation, Inc.,
 * 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
 */

require_once('constants.php');
require_once('misc.php');
require_once($np_dir . '/conf/config.php');

/**
 * UBB Code replacement class
 *
 * This file defines functions to handle UBB Code. This class has a poor
 * error handling for invalid ubb code but can handle locale specific UTF-8
 * characters.
 *
 * The following statements are replaced by this class:
 *
 *   [url]www.google.com[/url]  
 *          => <a href="http://www.google.com">www.google.com</a>
 *
 *   [url=http://www.google.com]Google[/url]
 *          => <a href="http://www.google.com">Google</a>
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
 *          => <span style="color:blue">blue text</span>
 *
 *   [center]centered text[/center]
 *          => <div style="text-align:center">centered text</div>
 *
 *   [small][/small]
 *          => <span style="font-size:small"></span>
 *
 *   [big][/big]
 *          => <span style="font-size:large"></span>
 *
 *   [img]http://host/picture.jpg[/img]
 *          => <img src="http://host/picture.jpg" title="http://host/picture.jpg" alt="" border="0" />
 *
 * @package Newsposter
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
	global $cfg;
	
        $this->text = $orig_text;
        $depth = 10; // ubb code can be nested 10 times
                     // (for not detected/replaced codes)

	// set locale for ctpye. with the 'u' pattern modifier locale specific
	// characters are matched by $pattern
	setlocale(LC_CTYPE, $cfg['Locale']);

        $valid_chars = 'a-zA-Z.,:;=\/\?&~!@% <>"0-9\+\-#\w';

        $pattern = "/\[(\w*)([$valid_chars]*)\]([$valid_chars]*)\[(\/\\1)\]/usi";

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

                $repl = sprintf('<a href="%s">%s</a>', $matches[2], $matches[3]);
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
                $repl = sprintf('<span style="color:%s">%s</span>', $matches[2], $matches[3]);
                return $repl;

            case 'center': // centered
                $repl = "<div style=\"text-align:center\">$matches[3]</div>";
                return $repl;

            case 'small':
                $repl = "<span style=\"font-size:small\">$matches[3]</span>";
                return $repl;

            case 'big':
                $repl = "<span style=\"font-size:large\">$matches[3]</span>";
                return $repl;

            case 'img':
                $repl = sprintf('<img src="%s" title="%s" alt="" style="border:none" />',
			$matches[3], $matches[3]);
                return $repl;
        }

        return $matches[0];
    }

}

?>
