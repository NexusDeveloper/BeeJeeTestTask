<?php

if(!function_exists('dd')){
	/**
	 * @param array ...$arguments
	 *
	 * @return bool
	 */
	function dd(...$arguments){
		if(empty($arguments))
			return config('app')->get('debug');
		
		if(!dd())
			return false;
		
		echo '<pre>';
		
		$trace=(new \Exception())->getTrace();
		if(!empty($trace)){
			$trace=reset($trace);
			echo
				PHP_EOL,
				'// called in: ',
				$trace['file'],
				'::',
				$trace['line'],
				PHP_EOL;
		};
		
		var_dump(...$arguments);
		echo '</pre>';
		
		exit;
	}
};