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
 *  - 0.9.0 ?
 *  - 0.5.2 Resurrection
 *  - 0.5.1 Falling leaves
 *  - 0.5.0 Odyssee
 *
 * @package Newsposter
 */

// misc
define('NP_VERSION'   , '0.9.0');
define('NP_CODENAME'  , '');
define('NP_COMB_NAME' , 'Newsposter/'.NP_VERSION.' ("'.NP_CODENAME.'")');
define('NP_USER_AGENT', 'User-Agent: '.NP_COMB_NAME);

// hashes used by Newsposter's authentication
define('NP_CRYPT', 1);
define('NP_SHA'  , 2);
define('NP_SSHA' , 3);
define('NP_MD5'  , 4);
define('NP_SMD5' , 5);
define('NP_PLAIN', 6);

// permission bits
define('NP_P_WRITE'          , 1);   // write      articles and comments
define('NP_P_EDIT'           , 2);   // edit   own articles and comments
define('NP_P_DELETE'         , 4);   // delete own articles and comments
define('NP_P_ARTICLES_EDIT'  , 8);   // edit   all articles
define('NP_P_ARTICLES_DELETE', 16);  // delete all articles
define('NP_P_COMMENTS_EDIT'  , 32);  // edit   all comments
define('NP_P_COMMENTS_DELETE', 64);  // delete all comments
// compounded permissions
define('NP_P_ALL_EDIT'       , NP_P_ARTICLES_EDIT   + NP_P_COMMENTS_EDIT);   // edit   all postings
define('NP_P_ALL_DELETE'     , NP_P_ARTICLES_DELETE + NP_P_COMMENTS_DELETE); // delete all postings

// default user classes
define('NP_WRITER'    , NP_P_WRITE + NP_P_EDIT);
define('NP_JOURNALIST', NP_P_WRITE + NP_P_EDIT + NP_P_COMMENTS_EDIT);
define('NP_EDITOR'    , NP_P_WRITE + NP_P_DELETE + NP_P_ALL_EDIT);
define('NP_ADMIN'     , NP_P_WRITE + NP_P_ALL_EDIT + NP_P_ALL_DELETE);

// used for comparison in NP_I18N::include_frame()
define('NP_HEADER', 1);
define('NP_FOOTER', 2);

// used for comparison in NP_Posting::get_posting_url()
define('NP_VIEW', 1);
define('NP_FORM', 2);

?>
