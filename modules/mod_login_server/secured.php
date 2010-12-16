<?php
/**
 * Web page that needs to be secured and copied under Joomla/Administrator/
 * Includes the standard index page to trigger the module's autologin features and redirect to index.php.
 *
 */

include('index.php');

$redirect = JRoute::_('index.php');
$mainframe->redirect($redirect);


