<?php
/* $Id$ */
//
// Authors: Frank Thomas <frank@thomas-alfeld.de>

/**
 *
 */
class NP_Tree {

    var tree = array();

    function add_node($parent, $content)
    {
	if (array_key_exists($parent, $this->tree))
	return NODE;
    }
    
    function delete_node()
    {}
    
    function get_parent()
    {}
    
    function get_children()
    {}
    
    function get_sibling()
    {}

    function display_tree()
    {}
    
    function thread2tree()
    {}
    
}

$t = new NP_Tree;
$t->add_node();;

?>
