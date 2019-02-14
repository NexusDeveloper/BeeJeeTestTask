<?php
declare(strict_types=1);
namespace Request;

use Helpers\Arr;

class Request{
	/**
	 * @return string
	 */
	static public function getRequestMethod():string{
		return strtolower(
			self::server('REQUEST_METHOD','get')
		);
	}
	
	/**
	 * @return bool
	 */
	static public function isAjax():bool{
		return self::server('X-REQUESTED-WITH')==='XMLHttpRequest';
	}
	
	/**
	 * @param string     $key
	 *
	 * @return bool
	 */
	static public function has(string $key):bool{
		foreach(self::getInputContainers() as &$container){
			if(Arr::has($container,$key))
				return true;
		};
		
		return false;
	}
	
	/**
	 * @param string     $key
	 * @param mixed|null $default
	 *
	 * @return mixed|null
	 */
	static public function input(string $key,$default=null){
		foreach(self::getInputContainers() as &$container){
			if(Arr::has($container,$key))
				return Arr::get($container,$key);
		};
		
		
		return $default;
	}
	
	/**
	 * @return array
	 */
	static public function getFormData():array{
		return $_POST?:[];
	}
	
	/**
	 * @param string     $key
	 * @param mixed|null $default
	 *
	 * @return string|null
	 */
	static public function server(string $key,$default=null){
		return self::getByContainer($_SERVER,$key,$default);
	}
	
	/**
	 * @param string     $key
	 * @param mixed|null $default
	 *
	 * @return string|null
	 */
	static public function cookie(string $key,$default=null){
		return self::getByContainer($_COOKIE,$key,$default);
	}
	
	/**
	 * @param string     $key
	 * @param mixed|null $default
	 *
	 * @return string|null
	 */
	static public function session(string $key,$default=null){
		return self::getByContainer($_SESSION,$key,$default);
	}
	
	/**
	 * @param array      $container
	 * @param string     $key
	 * @param mixed|null $default
	 *
	 * @return mixed|null
	 */
	static protected function getByContainer(array &$container,string $key,$default=null){
		return Arr::get($container,$key,$default);
	}
	
	/**
	 * @return array
	 */
	static protected function getInputContainers():array{
		return [
			&$_GET,
			&$_POST
		];
	}
	
	/**
	 * @return string
	 */
	static public function requestURI():string{
		list($res)=explode('?',self::server('REQUEST_URI')?:'');
		
		return $res;
	}
}