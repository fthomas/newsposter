<?php
/* $Id$ */
require_once('include/constants.php');

/**
 * Newsposter Configuration File
 *
 * All directives are explained in the documentation.
 */


/**
 * Your basic configuration
 */

// (string)
$cfg['PageDescription'] = 'My personal homepage!';

// (string)
$cfg['Language']    = 'german';

// (string)
$cfg['Locale']  = 'de_DE';

// (int)
$cfg['DateFormat']  = 1;

// (int)
$cfg['MaxPostings'] = 5;

// (int)
$cfg['CutOffAge']   = 0;

// (int)
$cfg['MarkFresh']   = 60 * 60 * 12;

// (int)
$cfg['MarkOld'] = 60 * 60 * 24 * 14;

// (bool)
$cfg['PostAnonymous']   = FALSE;

// (bool)
$cfg['ParseUBB']    = TRUE;

// (bool)
$cfg['SendMailOnError'] = TRUE;

// (bool)
$cfg['SendMailOnSuccess']   = TRUE;

// (string CSV)
$cfg['EmailTo'] = 'mrfrost@localhost,frank@thomas-alfeld.de';

// (string)
$cfg['EmailFrom']   = 'newsposter@localhost';

// (int)
$cfg['TimeVariance']     = 0;

// (bool)
$cfg['GenStaticHTML']    = FALSE;

// (bool)
$cfg['StripSlashes']     = FALSE;

// (bool)
$cfg['AllowChangeNames'] = TRUE;

// (string)
$cfg['NameVar']          = '';

// (string)
$cfg['StoreTypeFile']    = 'store_fs.php';


/**
 * Authentication
 */

// (bool)
$cfg['UseBuiltInAuth']  = TRUE;

$cfg['username'][0]     = 'newsposter';
$cfg['password'][0]     = 'insecure';
$cfg['permission'][0]   = SLAVE;

$cfg['username'][1]     = 'admin';
$cfg['password'][1]     = '{SSHA}i2J32p9b+99AVO9MkAoQWz6eBDc0ZTBjMGNjNQ==';
$cfg['permission'][1]   = ADMIN & ~P_WRITE;


/**
 * Authentication - LDAP
 */

// (bool)
$cfg['UseLDAPAuth'] = TRUE;

// (string)
$cfg['LDAPServer']  = 'localhost';

// (int)
$cfg['LDAPPort']    = 389;

// (string)
$cfg['SearchBase']  = 'ou=address_book,o=avalon';

// (string)
$cfg['BindDN']  = 'cn=admin,o=avalon';

// (string)
$cfg['BindPassword']    = 'anja';

// (string)
$cfg['UsernameAttr']    = 'cn';

// (string)
$cfg['PermAttr']    = 'note';

// (int)
$cfg['DefaultPerm'] = USER;


/**
 * Comments
 */

// (bool)
$cfg['AllowHTML']   = FALSE;

// (string)
$cfg['AllowedTags'] = '<p><a><i><b>'; 


/**
 * Design & Layout
 */

// (string)
$cfg['Theme']           = 'default';

// (string)
$cfg['IncludeHeader']   = '';

// (string)
$cfg['IncludeFooter']   = '';


/**
 * RDF Site Summary (RSS)
 */


/**
 * NNTP Gateway
 */

// (bool)
$cfg['PostNNTP']    = TRUE;

// (string)
$cfg['NNTPServer']  = 'localhost';

// (int)
$cfg['NNTPPort']    = 119;

// (string)
$cfg['NNTPUser']    = '';

// (string)
$cfg['NNTPPassword']    = '';

// (string)
$cfg['Newsgroup']  = 'de.alt.test';

// (string)
$cfg['FQDN']       = '';

// (string)
$cfg['Complaints'] ='postmaster@newsposter.org'


/**
 * Newsletter
 */


?>
