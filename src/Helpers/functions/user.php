<?php

if(!function_exists('user')){
	/**
	 * @return \App\Models\User|null
	 */
	function user():?App\Models\User{
		return \App\Services\UsersService::getCurrentUser();
	}
};