<?php
/* $Id$ */
//
// Authors: Frank Thomas <frank@thomas-alfeld.de>

// include all required files
require_once('misc.php');

/**
 *
 */
class NP_Blacklist {

    /**
     *
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
	
    }
    
}

?>
