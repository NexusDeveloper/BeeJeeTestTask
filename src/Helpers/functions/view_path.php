<?php

if(!function_exists('view_path')){
	/**
	 * @param string ...$path
	 *
	 * @return string
	 */
	function view_path(string ...$path):string{
		$path=array_map(function($path){
			return trim($path,DIRECTORY_SEPARATOR);
		},$path);
		
		
		return app()->viewPath(
			implode(DIRECTORY_SEPARATOR,$path)
		);
	}
};