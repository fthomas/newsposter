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

// Set this to the name of your homepage. It is used in the login head
// and in the RSS file.
// (string)
$cfg['PageTitle']   = 'www.example.com';

// Newsposter is multilingual. Here you can include the language file of
// your choice. Look into the lang/ directory for all available languages.
// If you write your own language file please contribute it.
// (filename)
include_once('lang/german.php');

// This should be the URL of your homepage.
// (string)
$cfg['PageURL']     = 'http://localhost/';

// This must be the valid URL (including http://) of Newsposter's index
// file. If it is not set correctly, Newsposter won't work. 
// (string)
$cfg['IndexURL']    = 'http://localhost:2080/~mrfrost/newsposter/index.php';

// This affects the date strings created by Newsposter. Weekday or month
// names will be translated according to this locale.
// (string)
$cfg['Locale']      = 'de_DE';

// Choose your preferred date format from the list below.
//  1)  24.12.1984 13:43	 2)  24.12.1984
//  3)  1984/12/24 13:43	 4)  1984/12/24
//  5)  Dezember 1984		 6)  Dezember 24 1984
//  7)  Montag, Dezember 24 @ 13:43:00 UTC
//  8)  (RFC 822 formatted)	 9)  11000.1100.11111000000
// 10)  (seconds since epoch)	11)  19841224134300
// 12)  Mon Dec 24 13:43:00 1984
// (int)
$cfg['DateFormat']  = 1;

// index.php?n_act=output_news will show up to 'MaxPostings'
// news postings. These are always the latest. 'output_all'
// instead shows all news and is not affected by this variable. 
// (int)
$cfg['MaxPostings'] = 5;

// If news postings are older than this in seconds they won't be
// shown by 'output_news'. 0 disables this option. 
// (int)
$cfg['CutOffAge']   = 0;

// If postings are not older than this in seconds they will be
// marked as "fresh" postings. 0 disables this option.
// (int)
$cfg['MarkFresh']   = 60 * 60 * 12;

// If postings are older than this in seconds they will be
// marked as "old" postings. 0 disables this option.
// (int)
$cfg['MarkOld']     = 60 * 60 * 24 * 7;

// Replace all UBB code with their html equivalent. Affects both,
// news and comments.
// (bool)
$cfg['ParseUBB']         = TRUE;

// This value in seconds is added to all displayed dates. If your
// server is misconfigured this may be useful. Negative values are
// allowed, too.
// (int)
$cfg['TimeVariance']     = 0;

// To avoid spamming with the email protocols and an extensive use
// of the comment function you can block IPs for a special time
// period. This value represents seconds. 0 disables this option.
// (int)
$cfg['BlacklistTime']    = 0;

// If PHP add slashes to " or ' (\" and \'), turn this on to remove
// them.
// (bool)
$cfg['StripSlashes']     = TRUE;

// If you want to forbid users to specify their name, change this
// to TRUE. Newsposter use the value of $cfg['NameVar'] instead. 
// (bool)
$cfg['AllowChangeNames'] = TRUE;

// Look above option. The NameVar has to be a PHP variable.
// (string)
$cfg['NameVar']          = '';

// Here you can specify the file with your preferred NP_Storage
// class. The default store_fs uses plain text files for storage.
// (string)
$cfg['StoreTypeFile']    = 'store_fs.php';

// This option is only available when using 'store_fs.php' as
// $cfg['StoreTypeFile']. All postings then are obtained from
// this source.
// E.g.: $cfg['RemoteSpoolDir'] = 'ftp://other.site.tld/newsposter/spool/';
// (string)
$cfg['RemoteSpoolDir']   = '';


/**
 * Authentication
 */

// If FALSE no authentication mechanism is used.
// (bool)
$cfg['UseBuiltInAuth']  = TRUE;

// This user has the login name 'newsposter' and the plain password
// 'insecure'. He's got SLAVE rights plus the permission to edit all
// postings.
$cfg['username'][0]     = 'newsposter';
$cfg['password'][0]     = 'insecure';
$cfg['permission'][0]   = SLAVE + P_EDIT_NEWS;

// This user has the login name 'admin' and a SSHA hashed password
// which is also 'insecure'. He's got ADMIN rights minus the permission
// to edit all postings.
$cfg['username'][1]     = 'admin';
$cfg['password'][1]     = '{SSHA}i2J32p9b+99AVO9MkAoQWz6eBDc0ZTBjMGNjNQ==';
$cfg['permission'][1]   = ADMIN & ~P_EDIT_NEWS;

// To specify new users:
//	$cfg['username'][2]   = '';
//	$cfg['password'][2]   = '';
//	$cfg['permission'][2] =   ;
// and so on ...


/**
 * Authentication (LDAP)
 */

// Newsposter can use LDAP entries for authentication.
// If you don't know what LDAP is, leave this to FALSE.
// (bool)
$cfg['UseLDAPAuth']  = FALSE;

// LDAP server address.
// (string)
$cfg['LDAPServer']   = 'localhost';

// LDAP server port.
// (int)
$cfg['LDAPPort']     = 389;

// LDAP search base.
// (string)
$cfg['SearchBase']   = 'ou=address_book,o=avalon';

// LDAP bind dn.
// (string)
$cfg['BindDN']       = 'cn=admin,o=avalon';

// LDAP bind password.
// (string)
$cfg['BindPassword'] = 'anja';

// The username is compared with this attribute.
// (string)
$cfg['UsernameAttr'] = 'cn';

// This attribute is used for the permission.
// (string)
$cfg['PermAttr']     = 'note';

// If 'PermAttr' is no valid user permission use this permission
// instead. 
// (int)
$cfg['DefaultPerm']  = USER;


/**
 * Comments
 */

// Turn this on if you want to use the comments function.
// (bool)
$cfg['UseComments']  = TRUE;

// If TRUE on the index.php?np_act=expanded sites an overview of
// the current thread is shown.
// (bool)
$cfg['ShowOverview'] = TRUE; 

// Allow HTML in comments here. This is very insecure, visitors
// can screw up your design or can place meta refresh tags in
// comments.
// (bool)
$cfg['AllowHTML']    = FALSE;

// If HTML is not allowed only these tags can be used.
// (string)
$cfg['AllowedTags']  = '<p><a><i><b>'; 


/**
 * Design & Layout
 */

// Specify your theme here. This name is equal to the directory
// name of the theme.
// (string)
$cfg['Theme']         = 'lenz';

// Specify here the files used for the content printed above and
// beneath Newsposter's output.
// (string)
$cfg['IncludeHeader'] = 'themes/'. $cfg['Theme'] .'/_header.inc';
$cfg['IncludeFooter'] = 'themes/'. $cfg['Theme'] .'/_footer.inc';

// These are used for the depth indicator.
// (string)
$cfg['DepthStart']  = '+';
$cfg['DepthLength'] = '-';
$cfg['DepthStop']   = '>';

// This color is used for the search matches.
// (string)
$cfg['MatchColor']  = '#ffe100';


/**
 * RDF Site Summary (RSS)
 */

// Turn RSS 1.0 creation on/off. Search the web for more information
// about RSS.
// (bool)
$cfg['RDFCreation']        = TRUE;

// All Comments are included into the RSS file.
// (bool)
$cfg['RDFIncludeComments'] = TRUE;

// This is the description of your site used in the RSS file.
// (string)
$cfg['RDFDescription']     = 'Example Homepage - www.example.com';

// The maximum of postings in your RSS file.
// (int)
$cfg['RDFMaxItems']        = 10;


/**
 * NNTP Gateway
 */

// Newsposter can post all postings to a NNTP server. It also
// sends cancel or supersede messages.
// (bool)
$cfg['PostNNTP']     = FALSE;

// NNTP server address.
// (string)
$cfg['NNTPServer']   = 'localhost';

// NNTP server port.
// (int)
$cfg['NNTPPort']     = 119;

// Username for server authentication. Leave blank for
// no authentication.
// (string)
$cfg['NNTPUser']     = '';

// Password for server authentication.
// (string)
$cfg['NNTPPassword'] = '';

// All postings are posted to this newsgroup.
// (string)
$cfg['Newsgroup']    = 'de.alt.test';

// The FQDN used for your message id.
// (string)
$cfg['FQDN']         = 'newsposter.webhop.org';

// This value is used for the additional X-Complaints-To header
// used in all postings.
// (string)
$cfg['Complaints']   = 'frank@thomas-alfeld.de';


/**
 * Mail and Newsletter
 */

// If TRUE Newsposter sends error protocols to all recipients in
// 'EmailTo'.
// (bool)
$cfg['SendMailOnError']   = FALSE;

// If TRUE Newsposter sends success protocols to all recipients
// in 'EmailTo' 
// (bool)
$cfg['SendMailOnSuccess'] = FALSE;

// This is the comma separated list of all recipients for the error
// and success protocols.
// (string CSV)
$cfg['EmailTo']        = 'mrfrost@localhost,frank@thomas-alfeld.de';

// This is used for the From header of all emails.
// (string)
$cfg['EmailFrom']      = 'mrfrost@localhost';

// If TRUE Newsposter send a small notice of new postings to the
// recipients in 'NewsletterTo'. The sent notice does not include the
// message body itself so that the recipients have to visit your site
// for reading the entire posting.
// (bool)
$cfg['SendNewsletter'] = FALSE;

// Comma separated list of all newsletter recipients.
// (string CSV)
$cfg['NewsletterTo']   = 'mrfrost@localhost,frank@thomas-alfeld.de';

?>
