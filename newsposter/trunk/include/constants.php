<?php
/* $Id$ */
//
// Authors: Frank Thomas <frank@thomas-alfeld.de>

/**
 * This file defines various constants.
 */

// misc
define('VERSION', '0.5.0');

// hashes used by Newsposter's authentication
define('CRYPT', 1);
define('SHA'  , 2);
define('SSHA' , 3);
define('MD5'  , 4);
define('SMD5' , 5);
define('PLAIN', 6);

// permission bits
define('P_WRITE'       , 1);  // write posting
define('P_EDIT'        , 2);  // edit own postings
define('P_DEL'         , 4);  // delete own postings
define('P_EDIT_NEWS'   , 8);  // edit all postings
define('P_DEL_NEWS'    , 16); // delete all postings
define('P_DEL_COMMENTS', 32); // delete comments 

// default user classes
define('SLAVE', P_WRITE);
define('USER' , P_WRITE | P_EDIT | P_DEL);
define('DUKE' , P_WRITE | P_EDIT | P_DEL | P_EDIT_NEWS | P_DEL_NEWS);
define('ADMIN', P_WRITE | P_EDIT | P_DEL | P_EDIT_NEWS | P_DEL_NEWS |
                P_DEL_COMMENTS);

?>
