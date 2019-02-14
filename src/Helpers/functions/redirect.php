<?php

if(!function_exists('redirect')){
	/**
	 * @param null|string $url
	 * @param bool        $permanent
	 *
	 * @return \Response\ResponseRedirect
	 */
	function redirect(?string $url=null,bool $permanent=false):\Response\ResponseRedirect{
		$instance=app(\Response\ResponseRedirect::class);
		if(empty($url))
			return $instance;
		
		return $instance->url($url,$permanent);
	}
};