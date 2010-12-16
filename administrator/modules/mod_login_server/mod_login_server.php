<?php

/**
 * Module entry point.
 *
 * @copyright	Copyright (C) 2010 University of Geneva
 * @author      laurent.opprecht@unige.ch
 * @license	GNU/GPL
 */
// no direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.language.helper');
require_once (dirname(__FILE__) . DS . 'helper.php');

$params = modLoginServerHelper::get_params();
$title = modLoginServerHelper::get_title();
$display_icon = modLoginServerHelper::get_display_icon();
$link_text = modLoginServerHelper::get_link_text();
$result = modLoginServerHelper::login();

require (dirname(__FILE__) . DS . 'default.php' );

