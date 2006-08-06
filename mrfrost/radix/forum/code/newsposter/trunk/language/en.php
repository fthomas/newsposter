<?php
/* $Id: en.php 240 2004-09-30 17:59:03Z mrfrost $
 *
 * This file is part of Newsposter
 * Copyright (C) 2001-2004 by Frank S. Thomas <frank@thomas-alfeld.de>
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

$lang = array(

    'login_head'   => 'Login',
    'login_user'   => 'Username',
    'login_pass'   => 'Password',
    'login_submit' => 'Login',
    'login_reset'  => 'Reset',
    'login_anonym' => 'anonymous',
    
    'radio_text'   => 'Choose action...',
    'radio_write'  => '<b>Write</b> posting',
    'radio_edit'   => '<b>Edit</b> posting',
    'radio_delete' => '<b>Delete</b> postings',
    'radio_submit' => 'Continue',

    'error'           => 'ERROR',
    'error_perm_text' => 'No permission',
    'error_perm_link' => 'Try another action',
    'error_auth_text' => 'Authentication failed',
    'error_auth_link' => 'Try to login again',
    
    'misc_name'      => 'Name',
    'misc_mail'      => 'Email',
    'misc_subject'   => 'Subject',
    'misc_article'   => 'Posting',
    'misc_comment'   => 'Comment',
    'misc_comments'  => 'Comments',
    'misc_unknown'   => 'unknown',
    'misc_topic'     => 'Topic',
    'misc_body'      => 'Body',
    'misc_emoticon'  => 'Emoticon',
    'misc_more'      => 'Read more...',
    'misc_selection' => 'Edit/delete selection',
    'misc_edit'      => 'Edit',
    'misc_delete'    => 'Delete',
    'misc_fresh'     => 'fresh posting',
    'misc_old'       => 'old posting',

    'perform_head'    => 'Compose posting',
    'perform_preview' => 'Preview',
    'perform_nl2br'   => 'Change newline to &lt;br /&gt;',
    
    'preview_head' => 'Preview',
    'preview_save' => 'Save',
    'preview_edit' => 'Edit', 
     
    // %s = $lang['misc_article'] or $lang['misc_comment']
    'mail_intro_success' => 'Following %s was just posted',
    'mail_intro_error'   => 'An access attempt was recorded',
    'mail_subj_error'    => 'Error protocol - ' . $cfg['PageTitle'],
    'mail_subj_new'      => 'New posting at '  . $cfg['PageTitle'],
    'mail_ip'            => 'IP address',
    'mail_hostname'      => 'Hostname',
    
    'emot_angry'     => 'angry',
    'emot_dead'      => 'dead',
    'emot_discuss'   => 'discussing',
    'emot_evil'      => 'evil',
    'emot_happy'     => 'happy',
    'emot_insane'    => 'insane',
    'emot_laughing'  => 'laughing',
    'emot_mean'      => 'mean',
    'emot_pissed'    => 'pissed',
    'emot_sad'       => 'sad',
    'emot_satisfied' => 'satisfied',
    'emot_shocked'   => 'shocked',
    'emot_sleepy'    => 'sleepy',
    'emot_suprised'  => 'suprised',
    'emot_uplooking' => 'uplooking',

    'comment_head'   => 'Comment news',
    'comment_send'   => 'Comment',
    'comment_answer' => 'Reply',
    
    'search_head'    => 'Search Newsposter\'s postings',
    'search_text'    => 'Search for',
    'search_in'      => 'in',
    'search_all'     => 'all postings',
    'search_comment' => 'comments',
    'search_news'    => 'news'
);

?>
