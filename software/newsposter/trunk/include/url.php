<?php

class NP_URL {

    function create_link($name, $target)
    {
        if ( false )
            return sprintf('<a href="mailto:%s">%s</a>', $target, $name);
    
        return sprintf('<a href="%s">%s</a>', $target, $name);
    }

}

?>
