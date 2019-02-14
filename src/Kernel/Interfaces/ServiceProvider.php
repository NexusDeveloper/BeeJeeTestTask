<?php
declare(strict_types=1);
namespace Kernel\Interfaces;

interface ServiceProvider{
	/**
	 * @return void
	 */
	public function register():void;
	
	/**
	 * Return array of ServiceProvider for registration
	 *
	 * @return ServiceProvider[]
	 */
	public function providers():array;
}