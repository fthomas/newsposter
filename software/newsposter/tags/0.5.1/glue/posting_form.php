<?php
/* $Id$ */
//
// Authors: Frank Thomas <frank@thomas-alfeld.de>

// include all required files
require_once('include/misc.php');
require_once('include/constants.php');
require_once('config.php');

// if we are coming directly from login
$_SESSION['NP']['auth_inst']->check_post();

// check auth
$_SESSION['NP']['auth_inst']->check_auth();
$_SESSION['NP']['auth_inst']->check_perm(array(P_WRITE, P_EDIT, P_EDIT_NEWS));

if (isset($_POST['edit']) && isset($_POST['cb'][0]))
{
    $old_post = $_SESSION['NP']['store_inst']->get_posting(prep_msgid($_POST['cb'][0]));
    $_SESSION['NP']['replace_msgid'] = $old_post['msgid'];
    
    $_SESSION['NP']['name']     = $old_post['name'];
    $_SESSION['NP']['mail']     = $old_post['mail'];
    $_SESSION['NP']['subject']  = $old_post['subject'];
    $_SESSION['NP']['topic']    = $old_post['topic'];
    $_SESSION['NP']['emoticon'] = $old_post['emoticon'];
    $_SESSION['NP']['body']     = $old_post['body'];
    $_SESSION['NP']['stamp']    = $old_post['stamp'];
}

$form       = $_SESSION['NP']['output_inst']->get_values_perform();
$topic_opts = $_SESSION['NP']['output_inst']->get_selection_topic($form['topic']);
$emots_opts = $_SESSION['NP']['output_inst']->get_selection_emots($form['emoticon']);

print_header();
require_once(create_theme_path('posting_form.inc'));
print_footer();

?>
