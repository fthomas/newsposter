<?php


$cfg['PageTitle']   = 'Newsposter Home';


$cfg['PageURL']     = 'http://newsposter.webhop.org/';


$cfg['IndexURL']    = 'http://localhost/~mrfrost/newsposter/index.php';

$cfg['DateFormat']  = 'am %x um %X';


$cfg['MaxPostings'] = 5;


$cfg['CutOffAge']   = 0;


$cfg['MarkFresh']   = 60 * 60 * 24;


$cfg['MarkOld']     = 60 * 60 * 24 * 7;


$cfg['ParseUBB']         = TRUE;

$cfg['TimeVariance']     = 0;

$cfg['BlacklistTime']    = 15;


$cfg['StripSlashes']     = TRUE;

$cfg['AllowChangeNames'] = TRUE;

$cfg['NameVar']          = '';


/**
 * Internationalization (i18n)
 */

$cfg['ContentNegotiation'] = TRUE;

$cfg['Language'] = 'de';
 
$cfg['Locale']   = 'de_DE';


/**
 * Authentication
 */

$cfg['UseBuiltInAuth']  = TRUE;


$cfg['username'][0]     = 'newsposter';
$cfg['password'][0]     = 'insecure';
$cfg['permission'][0]   = WRITER + P_DELETE;

$cfg['username'][1]     = 'admin';
$cfg['password'][1]     = '{SSHA}i2J32p9b+99AVO9MkAoQWz6eBDc0ZTBjMGNjNQ==';
$cfg['permission'][1]   = ADMIN & ~P_ARTICLES_EDIT;


/**
 * Comments
 */


$cfg['UseComments']  = TRUE;


$cfg['ShowOverview'] = TRUE; 


$cfg['AllowHTML']    = FALSE;


$cfg['AllowedTags']  = '<p><a><i><b>'; 


/**
 * Design & Layout
 */


$cfg['Theme'] = 'lenz';


$cfg['IncludeHeader'] = 'themes/lenz/Header.inc.de';
$cfg['IncludeFooter'] = 'themes/lenz/Footer.inc.de';


$cfg['DepthStart']    = '';
$cfg['DepthLength']   = '&nbsp;&nbsp;';
$cfg['DepthStop']     = '»';


$cfg['MatchColor']    = 'yellow';


$cfg['EvenLineColor'] = '#ebf9fe';


?>
