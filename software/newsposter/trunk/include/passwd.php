<?php
/* $Id$
 *
 * This file is part of 'Newsposter - A versatile weblog'
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

/**
 * Hashed passwords creation/comparison class
 *
 * This file defines functions to create and compare hashed passwords.
 * Except for CRYPT the mhash extension for PHP is needed to create
 * the hashes. ({@link http://mhash.sourceforge.net/})
 *
 * @package Newsposter
 */
class NP_Passwords {

    /**
     * @access	private
     * @return	string	The return value is an eight byte long random string.
     */
    function _gen_salt()
    {
        mt_srand((double)microtime()*1000000);
        $salt = substr(md5(mt_rand()), 4, 8);
        return $salt;
    }

    /**
     * @access	private
     * @param	string	$str1
     * @param	string	$str2
     * @return	bool
     */
    function _cmp_strings($str1, $str2)
    {
        return (strcmp($str1, $str2) == 0) ? TRUE : FALSE;
    }

    /**
     * @access	public
     * @param	string	$password
     * @param	int	$mode
     * @return	string
     */
    function create_hash($password, $mode = SSHA)
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
                $salt = $this->_gen_salt();
                $hash = mhash(MHASH_SHA1, $password . $salt);

                $hashed_password = '{SSHA}' . base64_encode($hash . $salt);
                return $hashed_password;

            case MD5:
                $hashed_password = '{MD5}' . base64_encode(mhash(MHASH_MD5, $password));
                return $hashed_password;

            case SMD5:
                $salt = $this->_gen_salt();
                $hash = mhash(MHASH_MD5, $password . $salt);

                $hashed_password = '{SMD5}' . base64_encode($hash . $salt);
                return $hashed_password;

            default:
                return $password;
        }
    }

    /**
     * @access	public
     * @param	string	$password
     * @param	string	$hash
     * @param	int	$mode
     * @return	bool
     */
    function cmp_known_hashes($password, $hash, $mode)
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

                return $this->_cmp_strings($hash, $new_hash);

            case SHA:
                $hash = base64_decode(substr($hash, 5));
                $new_hash = mhash(MHASH_SHA1, $password);

                return $this->_cmp_strings($hash, $new_hash);

            case SSHA:
                $hash = base64_decode(substr($hash, 6));
                // SHA-1 hashes are 160 bits long
                $orig_hash = substr($hash, 0, 20);
                $salt = substr($hash, 20);

                $new_hash = mhash(MHASH_SHA1, $password . $salt);
                return $this->_cmp_strings($orig_hash, $new_hash);

            case MD5:
                $hash = base64_decode(substr($hash, 5));
                $new_hash = mhash(MHASH_MD5, $password);

                return $this->_cmp_strings($hash, $new_hash);

            case SMD5:
                $hash = base64_decode(substr($hash, 6));
                // SMD5 hashes are 16 bytes long
                $orig_hash = substr($hash, 0, 16);
                $salt = substr($hash, 16);

                $new_hash = mhash(MHASH_MD5, $password . $salt);
                return _cmp_strings($orig_hash, $new_hash);

             case PLAIN:
                return $this->_cmp_strings($password, $hash);

            default:
                return FALSE;
        }
    }
    
    /**
     * @access	public
     * @param	string	$password
     * @param	string	$hash
     * @return	bool
     */
    function cmp_hashes($password, $hash)
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
            
        return $this->cmp_known_hashes($password, $hash, $mode);
    }
    
    /**
     * @access	public
     * @param	string	$string_mode
     * @return	int
     */
    function get_mode($string_mode)
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
