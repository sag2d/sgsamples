<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Welcome');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(false);

$routes->get('/', 'Welcome::index');
$routes->get('leagues', 'Leagues::index');
$routes->get('leagues/view/(:num)', 'Leagues::view/$1');
$routes->get('teams', 'Teams::index');
$routes->get('teams/view/(:num)', 'Teams::view/$1');
$routes->get('players', 'Players::index');
$routes->get('players/view/(:num)', 'Players::view/$1');

$routes->get('admin/league', 'Admin\League::index');
$routes->get('admin/league/index', 'Admin\League::index');
$routes->get('admin/league/edit', 'Admin\League::edit');
$routes->get('admin/league/edit/(:num)', 'Admin\League::edit/$1');
$routes->post('admin/league/save', 'Admin\League::save');
$routes->get('admin/league/delete/(:num)', 'Admin\League::delete/$1');

$routes->get('admin/team', 'Admin\Team::index');
$routes->get('admin/team/index', 'Admin\Team::index');
$routes->get('admin/team/edit', 'Admin\Team::edit');
$routes->get('admin/team/edit/(:num)', 'Admin\Team::edit/$1');
$routes->post('admin/team/save', 'Admin\Team::save');
$routes->get('admin/team/delete/(:num)', 'Admin\Team::delete/$1');

$routes->get('admin/player', 'Admin\Player::index');
$routes->get('admin/player/index', 'Admin\Player::index');
$routes->get('admin/player/edit', 'Admin\Player::edit');
$routes->get('admin/player/edit/(:num)', 'Admin\Player::edit/$1');
$routes->post('admin/player/save', 'Admin\Player::save');
$routes->get('admin/player/delete/(:num)', 'Admin\Player::delete/$1');
