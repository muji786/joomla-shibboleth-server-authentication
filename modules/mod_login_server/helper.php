<?php

// no direct access
defined('_JEXEC') or die('Restricted access');

/**
 * Helper functions for the module
 *
 * @version	1.0.0
 * @copyright	Copyright (C) 2010 Universitly of Geneva
 * @author      laurent.opprecht@unige.ch
 * @license	GNU/GPL
 */
class modLoginServerHelper {

    //parameters's name
    const PARAM_USERNAME = 'username';
    const PARAM_PASSWORD = 'password';
    const PARAM_REMEMBER = 'remember';
    const PARAM_DISPLAY_ICON = 'displayicon';
    const PARAM_LINK_TEXT = 'linktext';

    static $params = null;

    static function getReturnURL() {
        $params = self::$params;
        $type = self::getType();

        if ($itemid = $params->get($type)) {
            $menu = & JSite::getMenu();
            $item = $menu->getItem($itemid);
            if ($item) {
                $url = JRoute::_($item->link . '&Itemid=' . $itemid, false);
            } else {
                // stay on the same page
                $uri = JFactory::getURI();
                $url = $uri->toString(array('path', 'query', 'fragment'));
            }
        } else {
            // stay on the same page
            $uri = JFactory::getURI();
            $url = $uri->toString(array('path', 'query', 'fragment'));
        }

        return base64_encode($url);
    }

    static function getType() {
        $user = & JFactory::getUser();
        return (!$user->get('guest')) ? 'logout' : 'login';
    }

    /**
     * Returns true if the user is authenticated. False otherwise.
     * @return bool
     */
    static function is_authenticated() {
        $user = & JFactory::getUser();
        return!$user->get('guest');
    }

    /**
     * Returns true if the plugin can trigger the login. That is if the user is not already authenticated and if $_SERVER[$key_user_name] contains something. False otherwise.
     *
     * @return bool
     */
    static function can_authenticate() {
        if (self::is_authenticated()) {
            return false;
        }

        $user_name = self::get_user_name();
        return!empty($user_name);
    }

    /**
     * Tries to login the user provided by the web server.
     * @global JApplicatoin $app
     * @return bool
     */
    static function login() {
        if (!self::can_authenticate()) {
            return false;
        }

        $credentials = array(
            self::PARAM_USERNAME => self::get_user_name(),
            self::PARAM_PASSWORD => uniqid('', true)
        );

        $options = array(self::PARAM_REMEMBER => true);

        global $app;
        $result = $app->login($credentials, $options);
        if (!JError::isError($result)) {
            $redirect = JRoute::_('index.php');
            $app->redirect($redirect);
        }
        return $result;
    }

    /**
     * Returns the user name provied by the web server.
     *
     * @param string $default
     * @return string
     */
    static function get_user_name($default = '') {
        $key = self::$params->get(self::PARAM_USERNAME);
        $result = isset($_SERVER[$key]) ? $_SERVER[$key] : $default;

        return $result;
    }

    /**
     * Returns true if the icon is to be displayed. Returns $default otherwise.
     *
     * @param bool $default
     * @return bool
     */
    static function get_display_icon($default = true) {
        return (bool) self::$params->get(self::PARAM_DISPLAY_ICON, $default);
    }

    /**
     * Returns the text to be displayed on the login link.
     *
     * @param string $default
     * @return string
     */
    static function get_link_text() {
        return self::$params->get(self::PARAM_LINK_TEXT, '');
    }

}
