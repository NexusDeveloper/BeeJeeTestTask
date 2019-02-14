<?php
declare(strict_types=1);
namespace Container;

use Container\Exceptions\BadArgumentsException;
use Container\Exceptions\ClassNotFoundException;
use Container\Interfaces\InversionOfControlContainer;

/**
 * Class Container
 * @package Container
 */
class Container implements InversionOfControlContainer{
	static protected $instance;
	static protected $bindings=[];
	
	/**
	 * @param string $className
	 * @param array  $parameters
	 *
	 * @return mixed
	 * @throws ClassNotFoundException
	 * @throws BadArgumentsException
	 */
	static public function make(string $className,array $parameters=[]){
		if(!self::hasConcreteRealisation($className) and !class_exists($className))
			throw new ClassNotFoundException("Class [$className] not found");
		
		
		return self::getConcreteInstanceByAbstract($className,$parameters)?:
			self::makeInstance($className,$parameters);
	}
	
	/**
	 * @param string                 $abstract
	 * @param string|callable|object $concrete
	 */
	static public function bind(string $abstract,$concrete):void{
		self::$bindings[$abstract]=$concrete;
	}
	
	/**
	 * @param callable $callable
	 * @param array    $parameters
	 *
	 * @return mixed
	 */
	static public function call(callable $callable,array $parameters=[]){
		return call_user_func_array($callable,$parameters);
	}
	
	/**
	 * @param string $className
	 * @param array  $parameters
	 *
	 * @return mixed
	 */
	static protected function makeInstance(string $className,array $parameters=[]){
		return new $className(...array_values($parameters));
	}
	
	/**
	 * @param string $abstract
	 *
	 * @return bool
	 */
	static protected function hasConcreteRealisation(string $abstract):bool{
		return isset(self::$bindings[$abstract]);
	}
	
	/**
	 * @param string $abstract
	 * @param array  $parameters
	 *
	 * @return mixed|null
	 * @throws BadArgumentsException
	 * @throws ClassNotFoundException
	 */
	static protected function getConcreteInstanceByAbstract(string $abstract,array $parameters=[]){
		if(!self::hasConcreteRealisation($abstract))
			return null;
		
		return self::makeClassInstanceRealisation(
			self::$bindings[$abstract],
			$parameters
		);
	}
	
	/**
	 * @param string|callable|object $concrete
	 * @param array                  $parameters
	 *
	 * @return mixed
	 * @throws BadArgumentsException
	 * @throws ClassNotFoundException
	 */
	static private function makeClassInstanceRealisation($concrete,array $parameters=[]){
		if(is_string($concrete) and self::hasConcreteRealisation($concrete))
			return self::getConcreteInstanceByAbstract($concrete,$parameters);
		
		if(is_string($concrete) and !class_exists($concrete))
			throw new ClassNotFoundException("Class [$concrete] not found");
		
		if(is_string($concrete))
			$concrete=self::makeInstance($concrete,$parameters);
		
		$errorMessage='Is not a class instance';
		if(is_callable($concrete)){
			$concrete=self::call($concrete,$parameters);
			if(!is_object($concrete))
				throw new BadArgumentsException($errorMessage);
		};
		
		try{
			get_class($concrete);
		}catch(\Error $error){
			throw new BadArgumentsException($errorMessage);
		};
		
		
		return $concrete;
	}
	
	/**
	 * @param InversionOfControlContainer $container
	 */
	static protected function setInstance(InversionOfControlContainer $container):void{
		static::$instance=$container;
	}
	
	/**
	 * @return InversionOfControlContainer
	 */
	static public function getInstance():InversionOfControlContainer{
		return static::$instance?:static::$instance=static::make(
			static::class
		);
	}
}