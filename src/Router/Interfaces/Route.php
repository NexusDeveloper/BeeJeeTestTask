<?php
declare(strict_types=1);
namespace Router\Interfaces;

interface Route{
	/**
	 * @return bool
	 */
	public function isCurrentRoute():bool;
	
	/**
	 * @return mixed
	 */
	public function dispatch();
	
	/**
	 * @param string      $name
	 * @param mixed|null  $default
	 *
	 * @return mixed|null
	 */
	public function parameter(string $name,$default=null);
	
	/**
	 * @return array
	 */
	public function parameters():array;
	
	/**
	 * @param string $name
	 *
	 * @return Route
	 */
	public function name(string $name):self;
	
	/**
	 * @param array $parameters
	 *
	 * @return string
	 */
	public function getURL(array $parameters=[]):string;
}