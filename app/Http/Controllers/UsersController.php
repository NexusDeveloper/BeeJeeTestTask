<?php
declare(strict_types=1);
namespace App\Http\Controllers;

use ActiveRecord\Exceptions\NotFoundException;
use Request\Request;
use App\Services\UsersService;
use Response\Interfaces\Response;

class UsersController{
	/**
	 * @return \Response\Response|\Response\ResponseRedirect
	 */
	public function login():Response{
		$login=$password='';
		foreach(['login','password'] as $key)
			$$key=Request::input($key,'');
		
		if(empty($login) or empty($password))
			return redirect()->back()->with([
				'error'=>'Login and password are required fields'
			]);
		
		try{
			UsersService::signIn($login,$password);
			
			return redirect()->back();
		} catch(NotFoundException $e){
			return redirect()->back()->with([
				'error'=>'Login or password incorrect'
			]);
		};
	}
}