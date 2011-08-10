<?php
/**
 * Web page that needs to be secured and copied under Joomla/Administrator/
 * Includes the standard index page to trigger the module's autologin features and redirect to index.php.
 *
 */

/**
 * For testing remove that line for production
 * 
 * $_SERVER['Shib-SwissEP-UniqueID'] = 'usr_1';
 * $_SERVER['Shib-EP-Affiliation'] = 'member;staff;faculty';
 * $_SERVER['Shib-InetOrgPerson-givenName'] = 'John';
 * $_SERVER['Shib-Person-surname'] = 'Doe';
 * $_SERVER['Shib-InetOrgPerson-mail'] = 'john.doe@localhost.org';
 * $_SERVER['persistent-id'] = 'idp!viewer!drea34çcv3d';
 */

include('index.php');

$redirect = JRoute::_('index.php');
$app->redirect($redirect);