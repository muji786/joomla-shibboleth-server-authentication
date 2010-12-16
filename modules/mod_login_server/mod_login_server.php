<?php

/**
 * @version	1.0.0
 * @copyright	Copyright (C) 2010 Universitly of Geneva
 * @author      laurent.opprecht@unige.ch
 * @license	GNU/GPL
 *
 * Module's entry point.
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

// Include the syndicate functions only once
require_once (dirname(__FILE__) . DS . 'helper.php');

$params->def('greeting', 1);

$language = & JFactory::getLanguage();
$language->load('com_user');

modLoginServerHelper::$params = $params;
modLoginServerHelper::login();

$type = modLoginServerHelper::getType();
$return = modLoginServerHelper::getReturnURL();
$user = & JFactory::getUser();
$display_icon = modLoginServerHelper::get_display_icon();
$link_text = modLoginServerHelper::get_link_text();

require(JModuleHelper::getLayoutPath('mod_login_server'));