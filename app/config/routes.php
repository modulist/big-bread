<?php
/**
 * Routes configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different urls to chosen controllers and their actions (functions).
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2010, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2010, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       cake
 * @subpackage    cake.app.config
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

# Custom routing for API handling.
App::import( 'Lib', 'routes/ApiRoute' );

Router::parseExtensions( 'json', 'jsonp' );

/**
 * Here, we are connecting '/' (base path) to controller called 'Pages',
 * its action called 'display', and we pass a param to select the view file
 * to use (in this case, /app/views/pages/home.ctp)...
 */
	Router::connect('/', array('controller' => 'pages', 'action' => 'display', 'home'));
  
 /**
  * API Routing
  */
  Router::connect( '/api/:version/:controller/:action/*', array( 'controller' => 'api', 'action' => 'dispatch' ), array( 'routeClass' => 'ApiRoute', 'version' => 'v\d+' ) );
 
 /** Aliases */
  Router::connect( '/invite/:invite_code', array( 'controller' => 'users', 'action' => 'invite', array( 'invite_code' => '[a-fA-F0-9]{32}' ) ) );
  Router::connect( '/signup/*', array( 'controller' => 'users', 'action' => 'register' ) );
  Router::connect( '/login/*', array( 'controller' => 'users', 'action' => 'login' ) );
  Router::connect( '/logout/*', array( 'controller' => 'users', 'action' => 'logout' ) );
  Router::connect( '/profile/*', array( 'controller' => 'users', 'action' => 'edit' ) );
  Router::connect( '/questionnaire/*', array( 'controller' => 'buildings', 'action' => 'questionnaire' ) );
  Router::connect( '/feedback/*', array( 'controller' => 'contacts', 'action' => 'index' ) );
  Router::connect( '/locations/:action/*', array( 'controller' => 'buildings', 'action' => 'index' ) );

/**
 * ...and connect the rest of 'Pages' controller's urls.
 */
  Router::connect( '/pages/test', array( 'controller' => 'pages', 'action' => 'test' ) );
	Router::connect('/pages/*', array('controller' => 'pages', 'action' => 'display'));

/**
 * Variants that should never get used...but might.
 */
  Router::connect( '/users/invite/:invite_code', array( 'controller' => 'users', 'action' => 'invite', array( 'invite_code' => '[a-fA-F0-9]{32}' ) ) );
  
