<?php

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

function test_NP_Storing_String_get_posting()
{
    $posting = &new NP_Posting;
    
    $posting->name = 'Frank S. Thomas';
    $posting->msgid = '23';
    
    $store = &new NP_Storing_String;
    $store->store_posting($posting);
    
    var_dump($store->get_posting('23'));
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

function test_NP_Storing_String_store_posting()
{
    $posting = &new NP_Posting;
    
    $posting->name = 'Frank S. Thomas';
    $posting->created = time();
    
    $store = &new NP_Storing_String;
    $store->store_posting($posting);
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

function println($var)
{
    print $var . " <br />\n";
}

//test_NP_Posting_get_author();
//test_NP_Storing_String_store_posting();
//test_NP_Storing_String_set_database();
test_NP_Storing_String_msgid_exists();

?>
