<?php
/* $Id$ */
//
// Authors: Frank Thomas <frank@thomas-alfeld.de>

/**
 * Functions to handle/create date strings and unix time stamps
 * can be found in this file. The config vars $cfg['DateFormat']
 * and $cfg['Locale'] influences the behavior of these.
 *
 * Following date formats are supported:
 *
 *    1 =>    24.12.1984 13:43
 *
 *    2 =>    24.12.1984
 *
 *    3 =>    1984/12/24 13:43
 *
 *    4 =>    1984/12/24
 *
 *    5 =>    Dezember 1984
 *
 *    6 =>    Dezember 24 1984
 *
 *    7 =>    Montag, Dezember 24 @ 13:43:00 UTC
 *
 *    8 =>    (RFC 822 formatted date)
 *
 *    9 =>    11000.1100.11111000000 (binary notation)
 *
 *   10 =>    (seconds since the epoch (01.01.1970))
 *
 *   11 =>    19841224134300
 *
 *   12 =>    mbox-date: Mon Dec 24 13:43:00 1984
 *
 *   13 =>    1984-12-24T13:34:00Z
 */

/**
 * @param	int	$time_stamp
 * @return	string
 */
function stamp2string($time_stamp = -1, $format = 0)
{
	global $cfg;

	if ($time_stamp == -1)
		$time_stamp = time();
	
	// if $format is 0 use format number from config.php 
	if (isset($cfg['DateFormat']) && $format == 0)
		$format = $cfg['DateFormat'];

	setlocale(LC_TIME, $cfg['Locale']);

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
                        $time_string = date('Y-m-d\TH:i:s\Z', $time_stamp);
                        return $time_string;
                
		default:
			my_trigger_error("Invalid date format ($format)");
			return "01.01.1970";
	}
}

/**
 * @param	int	$format
 * @return	string 
 */
function my_date($format = 1)
{
    return stamp2string(-1, $format);
}
 
?>
