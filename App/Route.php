<?php

namespace App;

use MF\Init\Bootstrap;

class Route extends Bootstrap {

	public function initRoutes() {
		$routes['home'] = array(
			'route' => '/',
			'controller' => 'indexController',
			'action' => 'index'
		);

		$routes['sobreNos'] = array(
			'route' => '/sobreNos',
			'controller' => 'indexController',
			'action' => 'sobreNos'
		);

		$this->setRoutes($routes);
	}
}
