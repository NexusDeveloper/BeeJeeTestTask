<?php

if(!function_exists('view')){
	
	/**
	 * @param string $name
	 * @param array  $parameters
	 *
	 * @return \View\Interfaces\View|string
	 */
	function view(string $name,array $parameters=[]){
		$view=app(\View\Interfaces\View::class,[
			'view'=>$name
		]);
		if(!empty($parameters))
			return $view->render($parameters);
		
		return $view;
	};
};