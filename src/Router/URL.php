<?php
declare(strict_types=1);
namespace Router;

class URL{
	/**
	 * @param string $name
	 * @param array  $parameters
	 *
	 * @return string
	 */
	public function route(string $name,array $parameters=[]):string{
		$Route=Router::getRouteByName($name);
		if(!$Route)
			return '';
		
		return $Route->getURL($parameters);
	}
}