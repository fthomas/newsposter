<?php
/* $Id$
 *
 * This file is part of Newsposter
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
 * Various constants
 *
 * Here is a list of former codenames:
 *  - 0.5.3 ?
 *  - 0.5.2 Resurrection
 *  - 0.5.1 Falling leaves
 *  - 0.5.0 Odyssee
 *
 * @package Newsposter
 */

// misc
define('VERSION'   , '1.0.0');
define('CODENAME'  , '?');
define('COMB_NAME' , 'Newsposter/'.VERSION.' ("'.CODENAME.'")');
define('USER_AGENT', 'User-Agent: '.COMB_NAME);

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

// used for comparison in NP_I18N::include_frame()
define('HEADER', 1);
define('FOOTER', 2);

// used for comparison in NP_Posting::get_posting_url()
define('VIEW', 1);
define('FORM', 2);

?>
