<?php
/* $Id$ */
//
// Authors: Frank Thomas <frank@thomas-alfeld.de>

/**
 * The NP_Posting class can create postings and comments.
 * It also transforms the internal to the external posting
 * format and the other way round.
 *
 * The internal posting format (associative array):
 *
 *	array (
 *		'user'     => 'mrfrost {login username}',
 *		'name'     => 'Frank Thomas',
 *		'mail'     => 'frank@thomas-alfeld.de',
 *		'subject'  => 'Announcing Newsposter 0.5.0!',
 *		'msgid'    => '<{unique ID}@newsposter>',
 *		'date'     => '17.11.2002 14:34',
 *		'stamp'    => '{unix time stamp}',
 *		'topic'    => 'default',
 *		'emoticon' => 'happy',
 *		'body'     => 'hello.<br /> this is the content of the posting'
 *	);
 *
 * The external posting format (text only):  
 *
 *	From: Frank Thomas <frank@thomas-alfeld.de>
 *	Subject: Announcing Newsposter 0.5.0!
 *	Message-ID: <{unique ID}@newsposter>
 *	Date: Sun, 17 Nov 2002 14:34:23 +0100
 *	User-Agent: Newsposter/{version}
 *	X-NP-Name: Frank Thomas
 *	X-NP-Mail: frank@thomas-alfeld.de
 *	X-NP-User: mrfrost {login username}	
 *	X-NP-Stamp: {unix time stamp}
 *	X-NP-Topic: default
 *	X-NP-Emoticon: happy
 *	
 *	hello.<br /> this is the content of the posting
 *
 */

class NP_Posting {

}

?>