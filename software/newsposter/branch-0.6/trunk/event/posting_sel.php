<?php
/* $Id$ */
//
// Authors: Frank Thomas <frank@thomas-alfeld.de>

// include all required files
require_once('include/misc.php');
require_once('include/constants.php');

// check auth
$_SESSION['NP']['auth_inst']->check_auth();

$posts = array();

if (isset($_GET['edit']))
{
    // check permission for edit
    $_SESSION['NP']['auth_inst']->check_perm(
        array(P_EDIT, P_ARTICLES_EDIT, P_COMMENTS_EDIT));

    // create the form head
    $form_start  = "\n" . '<form action="index.php?np_act=posting_form" '
                 . 'method="post">' ."\n"
                 . '<p style="display:none"><input type="hidden" name="edit" /></p>' . "\n";
    
    $submit_text = $lang['misc_edit'];

    if ($_SESSION['NP']['auth_inst']->check_perm(P_EDIT, FALSE))
        $posts = $_SESSION['NP']['store_inst']->get_postings_from(
            $_SESSION['NP']['username']);
     
    if ($_SESSION['NP']['auth_inst']->check_perm(P_ARTICLES_EDIT, FALSE))
        $posts = $_SESSION['NP']['store_inst']->get_all_news();
    
    if ($_SESSION['NP']['auth_inst']->check_perm(P_COMMENTS_EDIT, FALSE))
        $posts = $_SESSION['NP']['store_inst']->get_all_comments();
        
    if ($_SESSION['NP']['auth_inst']->check_perm(P_ARTICLES_EDIT, FALSE) &&
        $_SESSION['NP']['auth_inst']->check_perm(P_COMMENTS_EDIT, FALSE))
    {
        $posts = $_SESSION['NP']['store_inst']->get_all_postings();
    }
}

if (isset($_GET['del']))
{
    // check permission for deletion
    $_SESSION['NP']['auth_inst']->check_perm(
        array(P_DELETE, P_ARTICLES_DELETE, P_COMMENTS_DELETE));
    
    // create the form head
    $form_start  = "\n" . '<form action="index.php?np_act=delete" '
                 . 'method="post">' . "\n"
                 . '<p style="display:none"><input type="hidden" name="delete" /></p>' . "\n";

    $submit_text = $lang['misc_delete'];
    
    if ($_SESSION['NP']['auth_inst']->check_perm(P_DELETE, FALSE)) 
        $posts = $_SESSION['NP']['store_inst']->get_postings_from(
            $_SESSION['NP']['username']);

    if ($_SESSION['NP']['auth_inst']->check_perm(P_ARTICLES_DELETE, FALSE))
	$posts = $_SESSION['NP']['store_inst']->get_all_news();
    
    if ($_SESSION['NP']['auth_inst']->check_perm(P_COMMENTS_DELETE, FALSE))
	$posts = $_SESSION['NP']['store_inst']->get_all_comments();
    
    if ($_SESSION['NP']['auth_inst']->check_perm(P_ARTICLES_DELETE, FALSE) &&
	$_SESSION['NP']['auth_inst']->check_perm(P_COMMENTS_DELETE, FALSE))
    {
        $posts = $_SESSION['NP']['store_inst']->get_all_postings();
    } 
}

$output  = $_SESSION['NP']['output_inst']->render_oview($posts, TRUE);
$output .= "\n</form>\n";

print_header();

print($form_start);
require_once(create_theme_path('posting_sel.inc'));
print($output);

print_footer();

?>
