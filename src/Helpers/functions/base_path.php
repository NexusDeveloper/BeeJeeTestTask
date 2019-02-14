<?php

if(!function_exists('base_path')){
	/**
	 * @param string ...$pathParts
	 *
	 * @return string
	 */
	function base_path(string ...$pathParts):string{
		$pathParts=array_map(function($part){
			return trim($part,DIRECTORY_SEPARATOR);
		},$pathParts);
		
		
		return app()->basePath(
			implode(DIRECTORY_SEPARATOR,$pathParts)
		);
	}
};