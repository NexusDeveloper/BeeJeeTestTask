<?php

use Router\Router;

Router::post('/login','\App\Http\Controllers\UsersController@login')
	->name('login');

Router::get('/sign-out',function(){
	\App\Services\UsersService::signOut();
	
	return redirect()->back();
})->name('logout');