<?php

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

jimport('joomla.plugin.plugin');

/**
 * Web server authentication plugin. I.e. authentication is done by the web server and user's data are available through $_SERVER;
 *
 * @version	1.0.0
 * @copyright	Copyright (C) 2010 University of Geneva.
 * @author      laurent.opprecht@unige.ch
 * @license	GNU/GPL
 */
class plgAuthenticationServer extends JPlugin {

    //Plugin parameters

    const PARAM_USER_NAME = "user_name";
    const PARAM_EMAIL = "email";
    const PARAM_FIRST_NAME = "first_name";
    const PARAM_LAST_NAME = "last_name";
    const PARAM_GENDER = "gender";
    const PARAM_LANGUAGE = "language";
    /**
     * Constructor
     *
     * For php4 compatability we must not use the __constructor as a constructor for plugins
     * because func_get_args ( void ) returns a copy of all passed arguments NOT references.
     * This causes problems with cross-referencing necessary for the observer design pattern.
     *
     * @param object $subject The object to observe
     * @param array  $config  An array that holds the plugin configuration
     * @since 1.5
     */
    function plgAuthenticationServer(& $subject, $config) {
        parent::__construct($subject, $config);
    }

    /**
     * This method should handle any authentication and report back to the subject
     *
     * @access	public
     * @param   array 	$credentials    Array holding the user credentials
     * @param 	array   $options        Array of extra options
     * @param	object	$response	Authentication response object
     * @return	boolean
     * @since 1.5
     */
    public function onUserAuthenticate($credentials, $options, JAuthenticationResponse &$response) {
        if($this->is_authenticated()){
            $response->status = JAUTHENTICATE_STATUS_SUCCESS;
            $response->error_message = '';
            $response->username = $this->get_user_name();
            $response->fullname = $this->get_full_name();
            $response->language = $this->get_language();
            $response->email = $this->get_email();
            $response->gender = $this->get_gender();
            $response->language = $this->get_language();
            //$response->password = uniqid('', true);
            $response->password_clear = uniqid('', true);
        }else{
            $response->status = JAUTHENTICATE_STATUS_FAILURE;
            $response->error_message = 'Failed to authenticate';
        }
    }

    /*
     * If available returns the server provided value for $name. If not returns $default.
     */
    public function get($name, $default = '') {
        $key = $this->params->get($name);
        return isset($_SERVER[$key]) ? $_SERVER[$key] : $default;
    }

    /**
     * Returns true if the user is authenticated. False otherwise.
     *
     * @return bool
     */
    public function is_authenticated(){
        $user_name = $this->get_user_name();
        return !empty($user_name);
    }

    /**
     * If available returns the user's name provided by the web server. If not returns an empty string ''.
     *
     * @return string
     */
    public function get_user_name() {
        return $this->get(self::PARAM_USER_NAME);
    }

    /**
     * If available returns the user's full name provided by the web server. That is the concatenation of first name and last name.  If not returns an empty string ''.
     *
     * @return string
     */
    public function get_full_name(){
        $result = array();
        $result[] = $this->get_first_name();
        $result[] = $this->get_last_name();
        $result = join(' ', $result);
        return $result;
    }

    /**
     * If available returns the user's first name provided by the web server. If not returns an empty string ''.
     *
     * @return string
     */
    public function get_first_name() {
        return $this->get(self::PARAM_FIRST_NAME);
    }

    /**
     * If available returns the user's last name provided by the web server. If not returns an empty string ''.
     *
     * @return string
     */
    public function get_last_name() {
        return $this->get(self::PARAM_LAST_NAME);
    }

    /**
     * If available returns the user's email provided by the web server. If not returns an empty string ''.
     *
     * @return string
     */
    public function get_email() {
        return $this->get(self::PARAM_EMAIL);
    }

    /**
     * If available returns the user's language provided by the web server. If not returns an empty string ''.
     *
     * @return string
     */
    public function get_language() {
        return $this->get(self::PARAM_LANGUAGE);
    }

    /**
     * If available returns the user's gender provided by the web server. If not returns an empty string ''.
     *
     * @return string
     */
    public function get_gender() {
        return $this->get(self::PARAM_GENDER);
    }

}
