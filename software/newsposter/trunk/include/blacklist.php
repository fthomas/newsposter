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

        $bl_file = $np_dir . '/spool/blacklist.txt';
    
        if (! file_exists($bl_file))
            touch($bl_file);
    
        if (! is_readable($bl_file))
        {
            my_trigger_error('Could not open blacklist file');
            return TRUE;        
        }
        
        $bl_fp = fopen($bl_file, 'r+');
        $size  = filesize($bl_file);
        $cont  = array();
        
        flock($bl_fp, LOCK_EX);
        
        if ($size != 0)
        {
            $cont = fread($bl_fp, $size);
            $cont = explode("\n", $cont);
        }
        
        $ip_addr  = $_SERVER['REMOTE_ADDR'];
        $hostname = gethostbyaddr($ip_addr );
        
        $new_cont = sprintf("%s:%s:%s\n", time(), $ip_addr, $hostname);
        $bool     = TRUE;

        foreach ($cont as $line)
        {
            if (empty($line))
                continue;

            $values = explode(':', $line);
            $diff   = time() - (int) $values[0];
            
            if ($diff >= $cfg['BlacklistTime'])
                continue;

            if ($ip_addr == $values[1])
            {
                $bool = FALSE;
                continue;
            }

            if ($diff < $cfg['BlacklistTime'])
                $new_cont .= sprintf("%s:%s:%s\n", time(), $ip_addr, $hostname);
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
