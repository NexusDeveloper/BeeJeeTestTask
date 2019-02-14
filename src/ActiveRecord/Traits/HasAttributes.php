<?php
declare(strict_types=1);
namespace ActiveRecord\Traits;

use Helpers\Arr;

trait HasAttributes{
	protected $attributes=[];
	
	/**
	 * @param array $attributes
	 *
	 * @return HasAttributes
	 */
	public function fill(array $attributes):self{
		$this->attributes=$attributes;
		
		return $this;
	}
	
	/**
	 * @param string $name
	 *
	 * @return bool
	 */
	public function hastAttribute(string $name):bool{
		return Arr::has($this->attributes,$name);
	}
	
	/**
	 * @param string $name
	 *
	 * @return mixed|null
	 */
	public function getAttribute(string $name){
		return Arr::get($this->attributes,$name);
	}
	
	/**
	 * @param string $name
	 * @param mixed  $value
	 *
	 * @return HasAttributes
	 */
	public function setAttribute(string $name,$value):self{
		Arr::set($this->attributes,$name,$value);
		
		return $this;
	}
	
	/**
	 * @return array
	 */
	public function getAttributes():array{
		return $this->attributes;
	}
	
	/**
	 * @param string $name
	 *
	 * @return mixed|null
	 */
	public function __get(string $name){
		return $this->getAttribute($name);
	}
}