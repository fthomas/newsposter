<?php
/* $Id$
 *
 * This file is part of 'Newsposter - A versatile weblog'
 * Copyright (C) 2001-2004 by Frank Thomas <frank@thomas-alfeld.de>
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

/**
 * Date handling functions
 *
 * Functions in this file handle or create date strings and UNIX
 * time stamps. Date strings are localized according to $cfg['Locale'].
 * Following date formats are supported:
 *  - 1 => 24.12.1984 13:43
 *  - 2 => 24.12.1984
 *  - 3 => 1984/12/24 13:43
 *  - 4 => 1984/12/24
 *  - 5 => Dezember 1984
 *  - 6 => Dezember 24 1984
 *  - 7 => Montag, Dezember 24 @ 13:43:00 UTC
 *  - 8 => Mon, 24 Dec 1984 13:43:00 +0200  // RFC 822 date format
 *  - 9 => 11000.1100.11111000000 // binary notation
 *  - 10 => // seconds since the epoch (01.01.1970)
 *  - 11 => 19841224134300
 *  - 12 => Mon Dec 24 13:43:00 1984 // mbox date format
 *  - 13 => 1984-12-24T13:34:00Z // ISO 8601 date format
 * If a string is used as format, it will directly passed to strftime as
 * format string. See {@link http://www.php.net/strftime}.
 *
 * @package Newsposter
 */

/**
 * @access    public
 * @param     int      $time_stamp    UNIX time stamp
 * @param     mixed    $format        An integer to choose one of Newsposter's
 *                         date format, or a format string, which is passed
 *                         directly to strftime.
 * @return    string   date, formatted according to $format
 */
function stamp2string($time_stamp = -1, $format = 0)
{
    global $cfg;

    if ($time_stamp == -1)
        $time_stamp = time();
    
    if (isset($cfg['DateFormat']) && $format == 0)
        $format = $cfg['DateFormat'];
        
    setlocale(LC_TIME, $cfg['Locale']);

    if (is_string($format))
    {
        $time_string = strftime($format, $time_stamp);
        return $time_string;
    }
    
    switch($format)
    {
        case 1:
            $time_string = strftime('%d.%m.%Y %H:%M', $time_stamp);
            return $time_string;

        case 2:
            $time_string = strftime('%d.%m.%Y', $time_stamp);
            return $time_string;

        case 3:
            $time_string = strftime('%Y/%m/%d %H:%M', $time_stamp);
            return $time_string;

        case 4:
            $time_string = strftime('%Y/%m/%d', $time_stamp);
            return $time_string;

        case 5:
            $time_string = strftime('%B %Y', $time_stamp);
            return $time_string;

        case 6:
            $time_string = strftime('%B %d %Y', $time_stamp);
            return $time_string;

        case 7:
            $time_string = strftime('%A, %B %d @ %T %Z', $time_stamp);
            return $time_string;

        case 8:
            $time_string = date('r', $time_stamp);
            return $time_string;

        case 9:
            $day   = decbin(date('d', $time_stamp));
            $month = decbin(date('m', $time_stamp));
            $year  = decbin(date('Y', $time_stamp));

            $time_string = "$day.$month.$year";
            return $time_string;

        case 10:
            $time_string = date('U', $time_stamp);
            return $time_string;

        case 11:
            $time_string = date('YmdHis', $time_stamp);
            return $time_string;

        case 12:
            $time_string = date('D M d H:i:s O Y', $time_stamp);
            return $time_string;

        case 13:
            $time_stamp -= date('Z');
            $time_string = date('Y-m-d\TH:i:s\Z', $time_stamp);
            return $time_string;
                
        default:
            my_trigger_error("Unrecognized date format: " . $format);
            $time_string = date('r', $time_stamp);
            return $time_string;
    }
}

/**
 * @access    public
 * @param     mixed     $format    An integer to choose one of Newsposter's
 *                          date format, or a format string, which is passed
 *                          directly to strftime.
 * @return    string    current date, formatted according to $format
 * @see       stamp2string
 */
function my_date($format = 1)
{
    return stamp2string(-1, $format);
}
 
?>
