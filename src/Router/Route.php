<?php
declare(strict_types=1);
namespace Router;

use Container\Exceptions\ClassNotFoundException;
use Container\Exceptions\MethodNotFoundException;
use Router\Interfaces\Route as RouteInterface;
use View\Interfaces\View;

class Route extends AbstractRoute implements RouteInterface{
	protected $dispatcher;
	
	/**
	 * Route constructor.
	 *
	 * @param string          $uri
	 * @param string|callable $dispatcher
	 *
	 * @throws ClassNotFoundException
	 * @throws MethodNotFoundException
	 */
	public function __construct(string $uri,$dispatcher){
		if(is_string($dispatcher)){
			$dispatcher=explode('@',$dispatcher,2);
			if(count($dispatcher)!=2)
				$dispatcher[]='__invoke';
			
			list($controller,$method)=$dispatcher;
			if(!class_exists($controller))
				throw new ClassNotFoundException("Controller [$controller] not found");
			
			$controllerInstance=new $controller();
			if(!method_exists($controllerInstance,$method))
				throw new MethodNotFoundException("Method [$method] not found in controller [$controller]");
			
			$dispatcher=[$controllerInstance,$method];
		};
		$this->uri=$uri?:'/';
		$this->dispatcher=$dispatcher;
	}
	
	/**
	 * @return mixed
	 */
	public function dispatch(){
		$response=app()->call(
			$this->dispatcher,
			$this->parameters()
		);
		if($response instanceof View)
			$response=$response->render();
		
		
		return $response;
	}
}