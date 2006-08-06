<?php
/**
 * Highlight a string in text without corrupting HTML tags
 *
 * @author      Aidan Lister <aidan@php.net>
 * @version     2.0
 * @param       string          $text        The text to search
 * @param       array|string    $needle      The string to highlight
 * @param       string          $start       Text to add to start highlighting
 * @param       string          $end         Text to add to end highlighting
 * @param       bool            $simple      Set to true to replace text disregarding HTML tags
 * @return      The text with the needle highlighted
 */
function str_highlight ($text, $needle, $start = "<strong>", $end = "</strong>", $simple = false)
{
    // Select pattern to use
    if ($simple === true) {
        // If there are no HTML tags to be worried about, use this
        $regex = '#(%s)#i';
    } else {
        // If there are HTML tags, we need to make sure we don't break them
        $regex = '#(?!<.*?)(%s)(?![^<>]*?>)#si';
    }

    $needle = (array) $needle;
    foreach ($needle as $needle_single) {
        $text = preg_replace(sprintf($regex, preg_quote($needle_single)), $start . '\1' . $end, $text);
    }

    return $text;
}

?>