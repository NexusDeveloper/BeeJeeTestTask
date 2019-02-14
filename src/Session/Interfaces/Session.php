<?php
declare(strict_types=1);
namespace Session\Interfaces;

interface Session{
	/**
	 * @param string $key
	 *
	 * @return bool
	 */
	public function has(string $key):bool;
	
	/**
	 * @param string $key
	 * @param        $default
	 *
	 * @return mixed
	 */
	public function get(string $key,$default=null);
	
	/**
	 * @param string $key
	 * @param        $value
	 *
	 * @return void
	 */
	public function set(string $key,$value):void;
}