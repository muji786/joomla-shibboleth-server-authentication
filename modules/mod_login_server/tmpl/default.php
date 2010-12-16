<?php
/**
 * User interface provided by the module.
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

if ($type == 'logout') {
    if ($params->get('greeting')) {
        echo '<div>';
        if ($params->get('name')) {
            echo JText::sprintf('HINAME', $user->get('name'));
        } else {
            echo JText::sprintf('HINAME', $user->get('username'));
        }
        echo '</div>';
    }
    echo '<a href="./index.php?option=com_user&task=logout">' . JText::_('BUTTON_LOGOUT') . '</a>';
} else {

    echo $params->get('pretext');

    echo '<a href="' . JRoute::_('secured.php') . '">';

    if ($display_icon) {
        echo '<img src="' . JURI::base() . 'modules/mod_login_server/tmpl/icon.gif" alt="' . $link_text . '">';
    } else {
        echo $link_text;
    }
    echo '</a>';

    echo $params->get('posttext');
}