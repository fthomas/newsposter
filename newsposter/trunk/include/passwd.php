<?php
/* $Id$ */
//
// Authors: Frank Thomas <frank@thomas-alfeld.de>

/**
 * This file defines functions to create and compare hashed passwords.
 * Except for CRYPT the mhash extension for PHP is needed to create
 * the hashes. (http://mhash.sourceforge.net/)
 */

// include all required files
require_once('constants.php');
require_once('misc.php'); 

class NP_Passwords {

    /**
     * @access  private
     * @returns string  The return value is an eight byte long random string.
     */
    function _genSalt()
    {
        mt_srand((double)microtime()*1000000);
        $salt = substr(md5(mt_rand()), 4, 8);
        return $salt;
    }

    /**
     * @param   string  $str1
     * @param   string  $str2
     * @access  private
     * @returns bool
     */
    function _cmpStrings($str1, $str2)
    {
        return (strcmp($str1, $str2) == 0) ? TRUE : FALSE;
    }

    /**
     * @param   string  $password
     * @param   int     $mode
     * @access  public
     * @returns string
     */
    function createHash($password, $mode = SSHA)
    {
        if ($mode != CRYPT && !function_exists('mhash'))
            $mode = PLAIN;

        switch($mode)
        {
            case CRYPT:
                $hashed_password = '{CRYPT}' . crypt($password);
                return $hashed_password;

            case SHA:
                $hashed_password = '{SHA}' . base64_encode(mhash(MHASH_SHA1, $password));
                return $hashed_password;

            // You need an explanation for the construction of SSHA hashes?
            // http://developer.netscape.com/docs/technote/ldap/pass_sha.html
            case SSHA:
                $salt = $this->_genSalt();
                $hash = mhash(MHASH_SHA1, $password . $salt);

                $hashed_password = '{SSHA}' . base64_encode($hash . $salt);
                return $hashed_password;

            case MD5:
                $hashed_password = '{MD5}' . base64_encode(mhash(MHASH_MD5, $password));
                return $hashed_password;

            case SMD5:
                $salt = $this->_genSalt();
                $hash = mhash(MHASH_MD5, $password . $salt);

                $hashed_password = '{SMD5}' . base64_encode($hash . $salt);
                return $hashed_password;

            default:
                return $password;
        }
    }

    /**
     * @param   string  $password
     * @param   string  $hash
     * @param   int     $mode
     * @access  public
     * @returns bool
     */
    function cmpKnownHashes($password, $hash, $mode)
    {
        if ($mode != CRYPT && !function_exists('mhash'))
            $mode = PLAIN;
            
        switch($mode)
        {
            case CRYPT:
                $hash = substr($hash, 7);
                // PHP's crypt(): salt + hash
                // note: "The encryption type is triggered by the salt argument."
                $salt = substr($hash, 0, CRYPT_SALT_LENGTH);
                $new_hash = crypt($password, $salt);

                return $this->_cmpStrings($hash, $new_hash);

            case SHA:
                $hash = base64_decode(substr($hash, 5));
                $new_hash = mhash(MHASH_SHA1, $password);

                return $this->_cmpStrings($hash, $new_hash);

            case SSHA:
                $hash = base64_decode(substr($hash, 6));
                // SHA-1 hashes are 160 bits long
                $orig_hash = substr($hash, 0, 20);
                $salt = substr($hash, 20);

                $new_hash = mhash(MHASH_SHA1, $password . $salt);
                return $this->_cmpStrings($orig_hash, $new_hash);

            case MD5:
                $hash = base64_decode(substr($hash, 5));
                $new_hash = mhash(MHASH_MD5, $password);

                return $this->_cmpStrings($hash, $new_hash);

            case SMD5:
                $hash = base64_decode(substr($hash, 6));
                // SMD5 hashes are 16 bytes long
                $orig_hash = substr($hash, 0, 16);
                $salt = substr($hash, 16);

                $new_hash = mhash(MHASH_MD5, $password . $salt);
                return _cmpStrings($orig_hash, $new_hash);

             case PLAIN:
                return $this->_cmpStrings($password, $hash);

            default:
                return FALSE;
        }
    }
    
    /**
     * @param   string  $password
     * @param   string  $hash
     * @access  public
     * @returns bool
     */
    function cmpHashes($password, $hash)
    {
        $three = strtoupper(substr($hash, 0, 5));
        $four  = strtoupper(substr($hash, 0, 6));
        $five  = strtoupper(substr($hash, 0, 7));

        if ($three == '{SHA}')
            $mode = SHA;
        elseif ($three == '{MD5}')
            $mode = MD5;
        elseif ($four == '{SSHA}')
            $mode = SSHA;
        elseif ($four == '{SMD5}')
            $mode = SMD5;
        elseif ($five == '{CRYPT}')
            $mode = CRYPT;
        else
            $mode = PLAIN;
            
        return $this->cmpKnownHashes($password, $hash, $mode);
    }
    
    /**
     * @param   string  $string_mode
     * @access  public
     * @returns int
     */
    function getMode($string_mode)
    {
        switch(strtoupper($string_mode))
        {
            case 'CRYPT':
                $hash_type = CRYPT;
                break;

            case 'SHA':
                $hash_type = SHA;
                break;

            case 'SSHA':
                $hash_type = SSHA;
                break;

            case 'MD5':
                $hash_type = MD5;
                break;

            case 'SMD5':
                $hash_type = SMD5;
                break;

            default:
                return FALSE;
        }

        return $hash_type;
    }

}

?>