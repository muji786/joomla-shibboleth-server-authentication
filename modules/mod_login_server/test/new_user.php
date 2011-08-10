<?php

/**
 * For testing.
 * 
 * Fill-in $_SERVER with dummy data for a new user
 * 
 * @copyright (c) 2011 University of Geneva
 * @license GNU General Public License - http://www.gnu.org/copyleft/gpl.html
 * @author Laurent Opprecht
 */

$id = time();

$_SERVER['Shib-SwissEP-UniqueID'] = 'usr_' . $id;
$_SERVER['Shib-EP-Affiliation'] = 'member;staff;faculty';
$_SERVER['Shib-InetOrgPerson-givenName'] = 'John';
$_SERVER['Shib-Person-surname'] = $id;
$_SERVER['Shib-InetOrgPerson-mail'] = 'john.'.$id.'@localhost.org';
$_SERVER['persistent-id'] = 'idp!viewer!' . md5($id);

?>