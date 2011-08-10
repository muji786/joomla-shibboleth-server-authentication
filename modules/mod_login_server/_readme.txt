DESCRIPTION

This module adds a login module to the front page, dispaying a login link that allow access through the web server authenticaton mecanism.
I.e. Shibboleth or any other identifying mecanism supported by the web server.

HOW IT WORKS

This module display module with a link on the frontpage.
The url links to a web page - secured.php - that must be secured at the web server level - i.e. Apache, Inernet Information Server, etc.
Once secured the page's access is only granted if the user is authenticated. If not an access denied message is sent back.
Once's granted users's data can be read from $_SERVER
If user's data are available from $_SERVER the module tries to login the user with it's username and a dummy password.

NOTE

This module does not provide a login screen for the admin part of this site. To do that you must install the mod_login_server module for the administrator.

User interface to capture the user name and the password - or any other idenfying scheme - is not provided by this module but by the
web server authentication mecanism.

Access to Joomla is not granted by this module but by the Server Authentication PLUGIN. That needs to be installed as well.

User autocreation is provided by the Joomla User Source PLUGIN. Which comes with the standard Joomla installation.

User default's role is configured in Site->Global Configuration->System->New User Registration Type

REQUIRED

If Shibboleth is used as the authentication mecanism then it must be installed and configured on the server.

The Server Authentication PLUGIN must be installed and enabled.

INSTALLATION

0 - change the login icon (optional)
    unzip the package
    replaces icon.gif by whatever icon you want
    zip the directory

1 - install the package.
        Log into joomla/administration
        Go to Extentions->install/uninstall
        Select the package and click Upload File & Install

2 - configure the package
        go to Extentions->Module Manager
        click on Administrator
        click on Login Web Server Authentication

        activate the module
        enter the title you want to have displayed on the login page
        enter the web server field name used to identify the logged in user
        add additional parameters as you see fit

3 - provide a page secured by the web server
        copy
            secured.php
        from the package's directory to
            /Joomla/secured.php

        Then secure the web page's access in your web server.
        For example to secure the web page in apache using the Shibboleth security module add

            <Location /Joomla/administrator/secured.php>
              AuthType shibboleth
              ShibRequestSetting requireSession 1
              require valid-user
            </Location>

4 - install/configure additional module if not already done
        - Web Server Authentication PLUGIN
        - mod login server MODULE for the frontpage
        - Joomla user source PLUGIN user autocreation
        - Global Settings new user role
