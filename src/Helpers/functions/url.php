<?php

if(!function_exists('url')){
	/**
	 * @return \Router\URL
	 */
	function url():\Router\URL{
		return app(\Router\URL::class);
	};
};