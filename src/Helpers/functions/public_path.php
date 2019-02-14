<?php

if(!function_exists('public_path')){
	/**
	 * @param string ...$path
	 *
	 * @return string
	 */
	function public_path(string ...$path):string{
		$path=array_map(function($path){
			return trim($path,DIRECTORY_SEPARATOR);
		},$path);
		
		
		return app()->publicPath(
			implode(DIRECTORY_SEPARATOR,$path)
		);
	}
};