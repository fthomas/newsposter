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
define('P_WRITE'          , 1);   // write      articles and comments
define('P_EDIT'           , 2);   // edit   own articles and comments
define('P_DELETE'         , 4);   // delete own articles and comments
define('P_ARTICLES_EDIT'  , 8);   // edit   all articles
define('P_ARTICLES_DELETE', 16);  // delete all articles
define('P_COMMENTS_EDIT'  , 32);  // edit   all comments
define('P_COMMENTS_DELETE', 64);  // delete all comments
// compounded permissions
define('P_ALL_EDIT'       , P_ARTICLES_EDIT   + P_COMMENTS_EDIT);   // edit   all postings
define('P_ALL_DELETE'     , P_ARTICLES_DELETE + P_COMMENTS_DELETE); // delete all postings

// default user classes
define('WRITER'    , P_WRITE + P_EDIT);
define('JOURNALIST', P_WRITE + P_EDIT + P_COMMENTS_EDIT);
define('EDITOR'    , P_WRITE + P_DELETE + P_ALL_EDIT);
define('ADMIN'     , P_WRITE + P_ALL_EDIT + P_ALL_DELETE);

// NP_I18N::include_frame()
define('HEADER', 1);
define('FOOTER', 2);

// NP_Posting::get_posting_url()
define('VIEW', 1);
define('FORM', 2);

?>
