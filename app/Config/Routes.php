<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Browse::index', ['as' => 'apps.dashboard']);
$routes->get('install', 'Install::index');
$routes->post('install/confirm', 'Install::index/confirm', ['as' => 'install.confirm']);
$routes->get('login', 'Home::index', ['as' => 'login']);
$routes->post('login/confirm', 'Home::login_confirm', ['as' => 'login.confirm']);
$routes->get('logout', 'Home::logout', ['as' => 'logout']);
$routes->get('apps', 'Browse::apps/1', ['as' => 'apps.panel']);
$routes->get('apps/(:num)', 'Browse::apps/$1');
$routes->get('app/(:segment)', 'Browse::app_show/$1', ['as' => 'app.manage']);
$routes->post('api/apps/(:segment)/(:segment)', 'Api\Apps::action/$1/$2');
$routes->get('api/apps/(:segment)/logs/(:segment)', 'Api\Apps::logs/$1/$2');
$routes->get('langs/list', 'Language::langs');
$routes->get('lang/switch/(:segment)', 'Language::switch/$1', ['as' => 'lang']);

$routes->group('my_account', static function($routes) {
    $routes->get('profile', 'Browse::profile', ['as' => 'user.profile']);
    $routes->get('settings', 'Browse::user_settings', ['as' => 'user.settings']);

    $routes->post('profile/update', 'Browse::profile/update', ['as' => 'user.profile.update']);
    $routes->post('settings/update', 'Browse::user_settings_update', ['as' => 'user.settings.update']);
});