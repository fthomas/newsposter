<?php
/* $Id$ */

/**
 *  Newsposter Configuration File
 * ===============================
 */


/**
 * Your basic configuration
 */

// Set this to the name of your homepage. It is used in the login head
// and in the RSS file.
// (string)
$cfg['PageTitle']   = 'Newsposter Home';

// This should be the URL of your homepage.
// (string)
$cfg['PageURL']     = 'http://newsposter.webhop.org/';

// This must be the valid URL (including http://) of Newsposter's index
// file. If it is not set correctly, Newsposter won't work. 
// (string)
$cfg['IndexURL']    = 'http://localhost/~mrfrost/newsposter/index.php';

// Choose your preferred date format from the list below.
//    1 =>    24.12.1984 13:43
//    2 =>    24.12.1984
//    3 =>    1984/12/24 13:43
//    4 =>    1984/12/24
//    5 =>    Dezember 1984
//    6 =>    Dezember 24 1984
//    7 =>    Montag, Dezember 24 @ 13:43:00 UTC
//    8 =>    Mon, 24 Dec 1984 13:43:00 +0200  // RFC 822 date format
//    9 =>    11000.1100.11111000000 // binary notation
//   10 =>    // seconds since the epoch (01.01.1970)
//   11 =>    19841224134300
//   12 =>    Mon Dec 24 13:43:00 1984 // mbox date format
//   13 =>    1984-12-24T13:34:00Z // ISO 8601 date format
// If you 
//http://www.php.net/strftime
// (int or string)
//$cfg['DateFormat']  = 1;
$cfg['DateFormat']  = 'am %x um %X';

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
$cfg['MarkFresh']   = 60 * 60 * 24;

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
$cfg['BlacklistTime']    = 15;

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


/**
 * Internationalization (i18n)
 */

// According to the 'Accept-Language' HTTP header Newsposter tries
// to determine the preferred language of your visitor and sets the
// $cfg['Language'] / $cfg['Locale'] variables accordingly. Newsposter
// will also look for localized header and footer files
// (see $cfg['IncludeHeader'] and $cfg['IncludeFooter']).
// If Newsposter and your visitor have no language in common
// your $cfg['Language'] setting is used as default language.
// (bool)
$cfg['ContentNegotiation'] = TRUE;

// Specify the language of Newsposter's visible output. Available
// languages are:
//     'de'    German
//     'en'    English
// Take a look into the lang directory if you want to translate Newsposter.
// When you are finished, please contribute your translation! :-)
// NOTE: This is a fallback if $cfg['ContentNegotiation'] is enabled.
// (string)
$cfg['Language'] = 'de';
 
// This affects the date strings created by Newsposter. Weekday or month
// names will be translated according to this locale.
// NOTE: This is a fallback if $cfg['ContentNegotiation'] is enabled.
// (string)
$cfg['Locale']   = 'de_DE';


/**
 * Authentication
 */

// If FALSE no authentication mechanism is used.
// (bool)
$cfg['UseBuiltInAuth']  = TRUE;

// This user has the login name 'newsposter' and the plain password
// 'insecure'. He's got WRITER rights plus the right to delete his own
// postings.
$cfg['username'][0]     = 'newsposter';
$cfg['password'][0]     = 'insecure';
$cfg['permission'][0]   = WRITER + P_DELETE;

// This user has the login name 'admin' and a SSHA hashed password
// which is also 'insecure'. He's got ADMIN rights minus the permission
// to edit all articles.
$cfg['username'][1]     = 'admin';
$cfg['password'][1]     = '{SSHA}i2J32p9b+99AVO9MkAoQWz6eBDc0ZTBjMGNjNQ==';
$cfg['permission'][1]   = ADMIN & ~P_ARTICLES_EDIT;

// To specify new users:
//  $cfg['username'][2]   = '';
//  $cfg['password'][2]   = '';
//  $cfg['permission'][2] =   ;
// and so on ...


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
$cfg['Theme'] = 'lenz';

// Specify here the files used for the content printed above and
// beneath Newsposter's output.
// If you enable $cfg['ContentNegotiation'] Newsposter will also
// look for localized versions of your header and footer files
// according to the preferred language of your visitor. Create
// your localized header/footer files:
//     header.inc.de // german header file 
//     header.inc.en // english header file 
//     header.inc.ja // japanese header file 
//     footer.inc.de // german footer file 
//     footer.inc.en // english footer file 
//     footer.inc.ja // japanese footer file
// and specify here the files you want to include if Newsposter and
// your visitor have no language in common.
//     $cfg['IncludeHeader'] = 'header.inc.de';
//     $cfg['IncludeFooter'] = 'footer.inc.de';
// Notice: If the language of your header/footer is not available as
//     Newsposter translation, you have to add it to the $avail_lang
//     array in include/i18n.php.
// (string)
$cfg['IncludeHeader'] = 'themes/lenz/Header.inc.de';
$cfg['IncludeFooter'] = 'themes/lenz/Footer.inc.de';

// These are used for the depth indicator.
// (string)
$cfg['DepthStart']    = '';
$cfg['DepthLength']   = '&nbsp;&nbsp;';
$cfg['DepthStop']     = '»';

// This color is used for the search matches.
// (string)
$cfg['MatchColor']    = 'yellow';

// Each even line in the Overview output has this background color.
// This is only available in the "lenz" theme.
// (string)
$cfg['EvenLineColor'] = '#ebf9fe';


/**
 * News Feeds (RSS 1.0/2.0 and Atom 0.3)
 */

// Turn RSS 1.0/2.0 and Atom 0.3 creation on/off.
// (bool)
$cfg['CreateFeeds']     = TRUE;

// All Comments are included into the news feeds.
// (bool)
$cfg['IncludeComments'] = TRUE;

// This is the description of your site used in the news feeds.
// (string)
$cfg['Description']     = 'Newsposter - The versatile weblog';

// The maximum of postings in your news feeds. 0 disables the
// limitation.
// (int)
$cfg['MaxFeedItems']    = 15;

// The maximum of words in each of your feed entry. After the last
// word in your entry Newsposter adds " ..." to it.
// A negative value disables this limitation.
// (int)
$cfg['MaxFeedWords']    = -1;


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
$cfg['Complaints']   = 'postmaster@your-domain.com';


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
