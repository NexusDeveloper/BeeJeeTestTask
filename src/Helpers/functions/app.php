<?php

if(!function_exists('app')){
	/**
	 * @param null|string $instance
	 * @param array       $parameters
	 *
	 * @return mixed|\Application\Application|\Container\Container
	 */
	function app(?string $instance=null,array $parameters=[]){
		$container=\Container\Container::make('app');
		if(is_null($instance))
			return $container;
		
		return $container->make($instance,$parameters);
	}
};