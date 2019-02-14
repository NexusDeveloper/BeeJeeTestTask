<?php
declare(strict_types=1);
namespace App\Services;

use ActiveRecord\Exceptions\NotFoundException;
use App\Models\User;

class UsersService{
	static protected $currentUser=false;
	
	/**
	 * @return User|null
	 */
	static public function getCurrentUser():?User{
		if(self::$currentUser!==false)
			return self::$currentUser;
		
		$uid=app('session')->get('user-id',null);
		if(!$uid)
			return self::$currentUser=null;
		
		return self::$currentUser=User::find((int) $uid);
	}
	
	/**
	 * @param string $login
	 * @param string $password
	 *
	 * @return User
	 * @throws NotFoundException
	 */
	static public function signIn(string $login,string $password):User{
		$res=User::search([
			'login'=>$login,
			'password'=>self::encryptPassword($password)
		],1,0);
		if(empty($res))
			throw new NotFoundException('User not found. Check login or password');
		
		$User=reset($res);
		self::setCurrentUser($User);
		
		
		return $User;
	}
	
	/**
	 * @param string $login
	 * @param string $password
	 *
	 * @return User
	 * @throws \Container\Exceptions\BadArgumentsException
	 * @throws \Container\Exceptions\ClassNotFoundException
	 */
	static public function signUp(string $login,string $password):User{
		$User=app()->make(User::class,[
			'attributes'=>[
				'login'=>$login,
				'password'=>self::encryptPassword($password)
			]
		])->save();
		self::setCurrentUser($User);
		
		
		return $User;
	}
	
	/**
	 * @return void
	 */
	static public function signOut():void{
		app('session')->set('user-id',null);
	}
	
	/**
	 * @param User $user
	 */
	static public function setCurrentUser(User $user):void{
		app('session')->set('user-id',$user->getAttribute('id'));
	}
	
	/**
	 * @param string $string
	 *
	 * @return string
	 */
	static private function getSalt(string $string){
		return md5($string);
	}
	
	/**
	 * @param string $password
	 *
	 * @return string
	 */
	static private function encryptPassword(string $password):string{
		return password_hash($password,PASSWORD_BCRYPT,[
			'salt'=>self::getSalt($password)
		]);
	}
}