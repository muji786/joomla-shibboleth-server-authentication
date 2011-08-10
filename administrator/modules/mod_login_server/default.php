<?php

/**
 * User interface provided by the module.
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

if (trim($title)) {
    echo "<h3>$title</h3>";
}

echo $params->get('pretext');

echo '<a href="' . JRoute::_('secured.php') . '">';
    if($display_icon){
        echo '<img src="' . JURI::base() . 'modules/mod_login_server/icon.gif" alt="' . $link_text  . '" />';
    }else{
        echo $link_text;
    }
echo '</a>';

echo $params->get('posttext');

?>
