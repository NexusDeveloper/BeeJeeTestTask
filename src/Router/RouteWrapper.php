<?php
declare(strict_types=1);
namespace Router;

use Router\Interfaces\Route;

class RouteWrapper{
	protected $route;
	protected $router;
	protected $onNameChanged;
	
	/**
	 * RouteWrapper constructor.
	 *
	 * @param Route    $route
	 * @param callable $onNameChanged
	 */
	public function __construct(Route $route,callable $onNameChanged){
		//TODO: написать event emitter и избавится от левых параметров
		$this->route=$route;
		$this->onNameChanged=$onNameChanged;
	}
	
	/**
	 * @param string $name
	 *
	 * @return RouteWrapper
	 */
	public function name(string $name):self{
		$this->route->name($name);
		app()->call($this->onNameChanged,[
			'name'=>$name
		]);
		
		return $this;
	}
}