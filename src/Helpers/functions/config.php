<?php

use Helpers\Arr;

if(!function_exists('config')){
	/**
	 * @param string $fileName
	 *
	 * @param null   $default
	 *
	 * @return mixed|\Config\Config
	 */
	function config(string $fileName,$default=null){
		if(Arr::isChainOfKeys([],$fileName)){
			$chain=Arr::chainToArray($fileName);
			$fileName=array_shift($chain);
			$chain=implode('.',$chain);
			
			return config($fileName)->get($chain,$default);
		};
		
		if(mb_strtolower(mb_substr($fileName,-4))!=='.php')
			$fileName.='.php';
		
		return app()->make('config',['fileName'=>$fileName]);
	};
};