<?php
/* $Id$ */
//
// Authors: Frank Thomas <frank@thomas-alfeld.de>

// include all required files
require_once('misc.php');

/**
 * This class tracks users and time of interaction and
 * checks whether the user should be blocked or not. 
 * @brief	Blacklist class for user blocking
 */
class NP_Blacklist {

    /**
     * @access	public
     * @return	bool
     */
    function validate_user()
    {
	global $cfg, $np_dir;
	 
	if ($cfg['BlacklistTime'] == 0)
	    return TRUE;
	
	$bl_file = $np_dir . '/spool/blacklist';
    
	if (!file_exists($bl_file))
	    touch($bl_file);
    
	if (($bl_fp = fopen($bl_file, 'r+')) === FALSE)
	{
	    my_trigger_error('Could not open blacklist file');
	    return TRUE;
	}
	
	flock($bl_fp, LOCK_EX);
	
	// read entire content
	$cont = fread($bl_fp, filesize($bl_file));
	$cont = explode("\n", $cont);
    
	$new_cont = sprintf("%s %s\n", $_SERVER['REMOTE_ADDR'], time());
	$bool     = TRUE;
	foreach ($cont as $line)
	{
	    if (empty($line))
		continue;
		
	    $values = explode(' ', $line);
	    $diff   = time() - (int) $values[1];
	    
	    if ($diff >= $cfg['BlacklistTime'])
		continue;
		
	    if ($_SERVER['REMOTE_ADDR'] == $values[0])
	    {
		$bool = FALSE;
		continue;
	    }
	    
	    if ($diff < $cfg['BlacklistTime'])
		$new_cont .= sprintf("%s %s\n", $values[0], time());
	}
	
	ftruncate($bl_fp, 0);
	fseek    ($bl_fp, 0);
	fwrite   ($bl_fp, $new_cont);
	
	flock($bl_fp, LOCK_UN);
	fclose($bl_fp);
	
	return $bool;
    }
    
}

?>
