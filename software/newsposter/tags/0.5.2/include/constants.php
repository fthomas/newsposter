<?php
/* $Id$ */
//
// Authors: Frank Thomas <frank@thomas-alfeld.de>

/**
 * This file defines various constants.
 */

// misc
define('VERSION'   , '0.5.2');
define('CODENAME'  , 'Resurrection');
define('COMB_NAME' , 'Newsposter/'.VERSION.' ("'.CODENAME.'")');
define('USER_AGENT', 'User-Agent: '.COMB_NAME);

// version codename history
// 0.5.2    Resurrection
// 0.5.1    Falling leaves
// 0.5.0    Odyssee


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
define('PEON' , 0);
define('SLAVE', P_WRITE);
define('USER' , P_WRITE | P_EDIT | P_DEL);
define('DUKE' , P_WRITE | P_EDIT | P_DEL | P_EDIT_NEWS | P_DEL_NEWS);
define('ADMIN', P_WRITE | P_EDIT | P_DEL | P_EDIT_NEWS | P_DEL_NEWS |
                P_DEL_COMMENTS);

// NP_I18N::include_frame()
define('HEADER', 1);
define('FOOTER', 2);

// NP_Posting::get_posting_url()
define('VIEW', 1);
define('FORM', 2);

?>
