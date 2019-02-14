<?php
declare(strict_types=1);
namespace Router;

use Container\Exceptions\BadArgumentsException;
use Response\Interfaces\Response;
use Router\Exceptions\NotFoundHttpException;
use Router\Interfaces\Route;
use Router\Interfaces\Router as RouterInterface;

class Router implements RouterInterface{
	const SUPPORTED_METHODS=[
		'get','post'
	];
	
	static protected $routes=[];
	static protected $namedRoutes=[];
	static protected $currentRoute;
	
	/**
	 * @return null|Route
	 */
	static public function getCurrentRoute():?Route{
		if(self::$currentRoute)
			return self::$currentRoute;
		
		$routes=self::$routes[
			app('request')->getRequestMethod()
		];
		
		/** @var Route $route */
		foreach($routes as $route){
			if($route->isCurrentRoute())
				return self::$currentRoute=$route;
		};
		
		
		return null;
	}
	
	/**
	 * @param string          $uri
	 * @param string|callable $dispatcher
	 *
	 * @return RouteWrapper
	 */
	static public function get(string $uri,$dispatcher){
		return self::request('get',$uri,$dispatcher);
	}
	
	/**
	 * @param string          $uri
	 * @param string|callable $dispatcher
	 *
	 * @return RouteWrapper
	 */
	static public function post(string $uri,$dispatcher){
		return self::request('post',$uri,$dispatcher);
	}
	
	/**
	 * @param string          $method
	 * @param string          $uri
	 * @param string|callable $dispatcher
	 *
	 * @return RouteWrapper
	 * @throws BadArgumentsException
	 * @throws \Container\Exceptions\ClassNotFoundException
	 */
	static public function request(string $method,string $uri,$dispatcher){
		if(!in_array($method,self::SUPPORTED_METHODS))
			throw new BadArgumentsException("Method [$method] not supported");
		
		if(!isset(self::$routes[$method]))
			self::$routes[$method]=[];
		
		$index=count(self::$routes[$method]);
		self::$routes[$method][$index]=app()->make(Route::class,[
			'uri'=>$uri,
			'dispatcher'=>$dispatcher
		]);
		$route=&self::$routes[$method][$index];
		
		
		return app(RouteWrapper::class,[
			'route'=>$route,
			'onNameChanged'=>function(string $name) use(&$route){
				self::$namedRoutes[$name]=$route;
			}
		]);
	}
	
	/**
	 * @return Response
	 * @throws NotFoundHttpException
	 */
	static public function dispatch():Response{
		$Route=self::getCurrentRoute();
		if(!$Route)
			throw new NotFoundHttpException('Route not found for current request');
		
		$response=$Route->dispatch();
		if(!($response instanceof Response))
			$response=response($response);
		
		
		return $response;
	}
	
	/**
	 * @param string $name
	 *
	 * @return null|Route
	 */
	static public function getRouteByName(string $name):?Route{
		return isset(self::$namedRoutes[$name])?
			self::$namedRoutes[$name]:
			null;
	}
}