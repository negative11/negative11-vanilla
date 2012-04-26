<?php
/**
 * Front controller.
 * 
 * This should be placed in the web root of your application. It handles
 * all incoming requests for pages. It is highly recommended that all
 * other framework-related files be kept outside of the web root to 
 * prevent unintended access. 
 * 
 * To force all requests to this page, you should use .htaccess or other
 * available methods. 
 * 
 * You can view an example .htaccess file here:
 * @example http://negative11.com/documentation/using-modrewrite
 *  
 * @package Application
 */

// Where does the framework live?
define ('ENVIRONMENT_ROOT', '/var/www/vanilla');

// Error reporting level
error_reporting(E_ALL | E_STRICT);

// Default file extension
define ('FILE_EXTENSION', '.php');

/**
 * This should be set to TRUE when deploying to production server. 
 * Doing so will disable some of the example code and debugger display. 
 * You can also test for this condition in your own code to disable 
 * certain features in production.
 */
define ('IN_PRODUCTION', FALSE);

/**
 * Define packages here. 
 * Packages extend the framework beyond base system functionality, and
 * it is recommended that you provide at least one package for your 
 * application.
 * 
 * Packages are stored in ENVIRONMENT_ROOT/packages.
 * The following array contains package folders relative to this path.
 * 
 * When model/view/controller conflicts occur, the package latest in the
 * array wins out. You can control explicit overloading of MVC 
 * components by organizing your packages accordingly.
 */
$packages = array 
(
	'mysql',
	'security',
	'test',
	'validation',
);

// Load the framework and go!
require_once ENVIRONMENT_ROOT . '/system/core/kickstart' . FILE_EXTENSION;
