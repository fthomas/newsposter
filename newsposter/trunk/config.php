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
$cfg['PageTitle']   = 'Blue Dwarf';

// (filename)
include_once('lang/german.php');

// (string)
$cfg['PageURL']     = 'http://localhost/';

// (string)
$cfg['IndexURL']    = 'http://localhost/~mrfrost/newsposter/index.php';

// (string)
$cfg['Locale']      = 'de_DE';

// (int)
$cfg['DateFormat']  = 1;

// (int)
$cfg['MaxPostings'] = 5;

// (int)
$cfg['CutOffAge']   = 0;

// (int)
$cfg['MarkFresh']   = 60 * 60 * 12;

// (int)
$cfg['MarkOld']     = 60 * 60 * 24;

// (bool)
$cfg['ParseUBB']         = TRUE;

// (int)
$cfg['TimeVariance']     = 0;

// (bool)
$cfg['StripSlashes']     = FALSE;

// (bool)
$cfg['AllowChangeNames'] = TRUE;

// (string)
$cfg['NameVar']          = '';

// (string)
$cfg['StoreTypeFile']    = 'store_fs.php';

// (string)
$cfg['RemoteSpoolDir']   = '';


/**
 * Authentication
 */

// (bool)
$cfg['UseBuiltInAuth']  = TRUE;

$cfg['username'][0]     = 'newsposter';
$cfg['password'][0]     = 'insecure';
$cfg['permission'][0]   = SLAVE + P_EDIT_NEWS;

$cfg['username'][1]     = 'admin';
$cfg['password'][1]     = '{SSHA}i2J32p9b+99AVO9MkAoQWz6eBDc0ZTBjMGNjNQ==';
$cfg['permission'][1]   = ADMIN & ~P_WRITE;


/**
 * Authentication (LDAP)
 */

// (bool)
$cfg['UseLDAPAuth']  = TRUE;

// (string)
$cfg['LDAPServer']   = 'localhost';

// (int)
$cfg['LDAPPort']     = 389;

// (string)
$cfg['SearchBase']   = 'ou=address_book,o=avalon';

// (string)
$cfg['BindDN']       = 'cn=admin,o=avalon';

// (string)
$cfg['BindPassword'] = 'anja';

// (string)
$cfg['UsernameAttr'] = 'cn';

// (string)
$cfg['PermAttr']     = 'note';

// (int)
$cfg['DefaultPerm']  = USER;


/**
 * Comments
 */

// (bool)
$cfg['UseComments'] = TRUE;

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

// (bool)
$cfg['RDFCreation']        = TRUE;

// (bool)
$cfg['RDFIncludeComments'] = TRUE;

// (string)
$cfg['RDFDescription']     = 'Blue Dwarf - Frank Thomas personal homepage';

// (int)
$cfg['RDFMaxItems']        = 20;


/**
 * NNTP Gateway
 */

// (bool)
$cfg['PostNNTP']     = TRUE;

// (string)
$cfg['NNTPServer']   = 'localhost';

// (int)
$cfg['NNTPPort']     = 119;

// (string)
$cfg['NNTPUser']     = '';

// (string)
$cfg['NNTPPassword'] = '';

// (string)
$cfg['Newsgroup']    = 'de.alt.test';

// (string)
$cfg['FQDN']         = 'newsposter.webhop.org';

// (string)
$cfg['Complaints']   = 'frank@thomas-alfeld.de';


/**
 * Mail and Newsletter
 */
 
// (bool)
$cfg['SendMailOnError']   = FALSE;

// (bool)
$cfg['SendMailOnSuccess'] = TRUE;

// (string CSV)
$cfg['EmailTo']        = 'mrfrost@localhost,frank@thomas-alfeld.de';

// (string)
$cfg['EmailFrom']      = 'newsposter@localhost';

// (bool)
$cfg['SendNewsletter'] = TRUE;

// (string CSV)
$cfg['NewsletterTo']   = 'mrfrost@localhost,frank@thomas-alfeld.de';

?>
