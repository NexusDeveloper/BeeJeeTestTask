<?php
declare(strict_types=1);
namespace Session;

use Helpers\Arr;
use Session\Interfaces\Session as SessionInterface;

class Session implements SessionInterface{
	
	/**
	 * @param string $key
	 *
	 * @return bool
	 */
	public function has(string $key):bool{
		return Arr::has($this->getContainer(),$key);
	}
	
	/**
	 * @param string $key
	 * @param        $default
	 *
	 * @return mixed
	 */
	public function get(string $key,$default=null){
		return Arr::get($this->getContainer(),$key,$default);
	}
	
	/**
	 * @param string $key
	 * @param        $value
	 *
	 * @return void
	 */
	public function set(string $key,$value):void{
		Arr::set($this->getContainer(),$key,$value);
	}
	
	/**
	 * @return mixed
	 */
	protected function &getContainer(){
		return $_SESSION;
	}
}