<?php
/* $Id$
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

require_once('posting.php');
require_once('storing.php');

function test_NP_Posting_get_author()
{
    $posting = &new NP_Posting;
    
    println($posting->get_author());
    
    $posting->name = 'Frank S. Thomas';
    println($posting->get_author());
    
    $posting->uri = 'frank@thomas-alfeld.de';
    println($posting->get_author());
    
    $posting->name = '';
    println($posting->get_author());
    
    $posting->uri = 'http://www.thomas-alfeld.de/frank/';
    println($posting->get_author());
    
    $posting->uri = 'www.thomas-alfeld.de/frank/';
    println($posting->get_author());
    
    // error case:
    //  - invalid HTML in name
    //  - malformed URI 
    $posting->name = 'Frank <b>';
    $posting->uri = '://www.thomas-alfeld.de/frank/';
    println($posting->get_author());
}

function test_NP_Storing_String_set_database($name = 'test')
{
    $posting = &new NP_Posting;
    
    $posting->name = 'Frank S. Thomas';
    $posting->created = time();
    
    $store = &new NP_Storing_String;
    $store->set_database($name);
    $store->store_posting($posting);
}

function test_NP_Storing_String_get_posting()
{
    $posting = &new NP_Posting;
    
    $posting->name = 'Frank S. Thomas';
    $posting->msgid = '23';
    
    $store = &new NP_Storing_String;
    $store->store_posting($posting);
    
    var_dump($store->get_posting('23'));
}

function test_NP_Storing_String_get_thread()
{
    $posting1 = &new NP_Posting;
    $posting1->name = 'Frank';
    $posting1->msgid = '1';
    
    $posting2 = &new NP_Posting;
    $posting2->name = 'mrfrost';
    $posting2->msgid = '2';
    $posting2->refs = array('1');
    
    $posting3 = &new NP_Posting;
    $posting3->name = 'Herr Thomas';
    $posting3->msgid = '3';    
    $posting3->refs = array('2', '1');
    
    $posting4 = &new NP_Posting;
    $posting4->name = 'Frank Stefan';
    $posting4->msgid = '4';    
    $posting4->refs = array('3', '2', '1');
        
    $store = &new NP_Storing_String;
    $store->store_posting($posting1);
    $store->store_posting($posting2);
    $store->store_posting($posting3);
    $store->store_posting($posting4);
    
    var_dump($store->get_thread('2'));
}

function test_NP_Storing_String_store_posting()
{
    $posting = &new NP_Posting;
    
    $posting->name = 'Frank S. Thomas';
    $posting->created = time();
    
    $store = &new NP_Storing_String;
    $store->store_posting($posting);
}

function test_NP_Storing_String_replace_posting()
{
    $posting1 = &new NP_Posting;
    $posting1->name = 'Frank';
    $posting1->msgid = '2';
    
    $posting2 = &new NP_Posting;
    $posting2->name = 'mrfrost';
    $posting2->msgid = '1';
    
    $store = &new NP_Storing_String;
    $store->store_posting($posting1);
    $store->replace_posting($posting2, '2');
}

function test_NP_Storing_String_msgid_exists()
{
    $posting = &new NP_Posting;
    
    $posting->name = 'Frank S. Thomas';
    $posting->msgid = '23';
    
    $store = &new NP_Storing_String;
    $store->store_posting($posting);
    
    var_dump($store->msgid_exists('24'));
}

function test_crypt()
{
    // STD_DES
    println( CRYPT_STD_DES );
    println( crypt('test', '12') );
    
    // EXT_DES
    println( CRYPT_EXT_DES );
    println( crypt('test', '123456789') );
    
    // MD5
    println( CRYPT_MD5 );
    println( crypt('test', '$1$456789012') );
    
    // BLOWFISH
    println( CRYPT_BLOWFISH );
    println( crypt('test', '$2$4567890123456') );
}

function println($var)
{
    print $var . " <br />\n";
}

//test_NP_Posting_get_author();
//test_NP_Storing_String_store_posting();
//test_NP_Storing_String_set_database();
//test_NP_Storing_String_msgid_exists();
//test_NP_Storing_String_replace_posting();
//test_NP_Storing_String_get_thread();
test_crypt();

?>
