<?php
/**
 * Routes configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different URLs to chosen controllers and their actions (functions).
 *
 * PHP 5
 *
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Config
 * @since         CakePHP(tm) v 0.2.9
 */

/**
 * Here, we are connecting '/' (base path) to controller called 'Pages',
 * its action called 'display', and we pass a param to select the view file
 * to use (in this case, /app/View/Pages/home.ctp)...
 */
	Router::connect('/', array('controller' => 'pages', 'action' => 'display', 'home'));
	Router::connect('/dictionnaire', array('controller' => 'pages', 'action' => 'display', 'dico'));
    
    Router::connect('/login', array('controller' => 'users', 'action' => 'login', 'plugin' => false));
    Router::connect('/logout', array('controller' => 'users', 'action' => 'logout', 'plugin' => false));
    Router::connect('/users', array('controller' => 'users', 'action' => 'index', 'plugin' => false));
    Router::connect('/users/:action/*', array('controller' => 'users', 'action' => '[a-z]+', 'plugin' => false));
    Router::connect('/groups', array('controller' => 'groups', 'action' => 'index', 'plugin' => false));
    Router::connect('/groups/:action/*', array('controller' => 'groups', 'action' => '[a-z]+', 'plugin' => false));
    Router::connect('/accounts', array('controller' => 'accounts', 'action' => 'index', 'plugin' => false));
    Router::connect('/accounts/:action/*', array('controller' => 'accounts', 'action' => '[a-z]+', 'plugin' => false));

/**
 * ...and connect the rest of 'Pages' controller's URLs.
 */
	Router::connect('/pages/*', array('controller' => 'pages', 'action' => 'display'));

/**
 * Load all plugin routes. See the CakePlugin documentation on
 * how to customize the loading of plugin routes.
 */
	CakePlugin::routes();
    
    Router::parseExtensions('pdf');

/**
 * Load the CakePHP default routes. Only remove this if you do not want to use
 * the built-in default routes.
 */
	require CAKE . 'Config' . DS . 'routes.php';
