<?php

// no direct access
defined('_JEXEC') or die('Restricted access');

/**
 * Helper functions used by the module
 *
 * @copyright	Copyright (C) 2010 University of Geneva
 * @author      laurent.opprecht@unige.ch
 * @license	GNU/GPL
 */
class modLoginServerHelper {

    const PARAM_USERNAME = 'username';
    const PARAM_PASSWORD = 'password';
    const PARAM_REMEMBER = 'remember';
    const PARAM_DISPLAY_ICON = 'displayicon';
    const PARAM_LINK_TEXT = 'linktext';

    static $params = null;
    static $title = '';

    /**
     * Initialize the module. Ensure params and title are read from the database for the module.
     * Note that $params is not available from the global context when called from the login screen.
     * The reason being that this module require administrative access from the current user and that is not available before login.
     */
    static function init() {
        if(self::$params){
            return;
        }
        
        $modules = array();

        $db = & JFactory::getDBO();
        /**
         * client_id = 1 means admin access
         * client_id = 0 means frontend access
         */
        $query = 'SELECT * '
                . ' FROM #__modules AS m'
                . " WHERE m.module = 'mod_login_server' AND client_id=1";
        $db->setQuery($query);

        $modules = $db->loadObjectList();
        $params = is_array($modules) ? reset($modules)->params : false;
        $params = $params !== false ? new JParameter($params) : null;
        self::$params = $params;


        $title = is_array($modules) ? reset($modules)->title : '';
        self::$title = $title;
    }

    /**
     * Returns the module's parameters.
     *
     * @return JParameter
     */
    static function get_params() {
        self::init();
        return self::$params;
    }

    /**
     * Returns the module's title.
     *
     * @return string
     */
    static function get_title() {
        self::init();
        return self::$title;
    }

    static function getReturnURL() {
        $params = self::$params;
        $type = self::getType();

        if ($itemid = $params->get($type)) {
            $menu = & JSite::getMenu();
            $item = $menu->getItem($itemid); //var_dump($menu);die;
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
     * Returns true if the user is already identified. False otherwise.
     * @return bool
     */
    static function is_authenticated() {
        $user = & JFactory::getUser();
        return!$user->get('guest');
    }

    /**
     * Returns true if the module can try to authenticate the web server user. False otherwise.
     * That is the case if he has not been identified already and if the web server returned something.
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
     * Tries to login the web server user with a dummy passsword.
     *
     * @global JFrame $app
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
     * Returns user name provided by the web server if one exists. Returns $default otherwise.
     *
     * @param string $default
     * @return string
     */
    static function get_user_name($default = '') {
        self::init();
        $key = self::$params->get(self::PARAM_USERNAME);
        $result = isset($_SERVER[$key]) ? $_SERVER[$key] : $default;

        return $result;
    }

    /**
     * Returns true to display the icon. False otherwise.
     *
     * @return bool
     */
    static function get_display_icon($default = true) {
        self::init();
        return (bool)self::$params->get(self::PARAM_DISPLAY_ICON, $default);
    }

    /**
     * Returns the text to be display for the login link.
     *
     * @param string $default
     * @return string
     */
    static function get_link_text() {
        self::init();
        return  self::$params->get(self::PARAM_LINK_TEXT, '');
    }

}

