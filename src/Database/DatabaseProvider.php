<?php
declare(strict_types=1);
namespace Database;

use Kernel\Providers\AbstractServiceProvider;

class DatabaseProvider extends AbstractServiceProvider{
	
	/**
	 * @return void
	 */
	public function register():void{
		$database=new Database([
			'database_type'=>$dbDriver=config('database.driver'),
			'database_name'=>config("database.${dbDriver}.name"),
			'server'=>config("database.${dbDriver}.host"),
			'username'=>config("database.${dbDriver}.user"),
			'password'=>config("database.${dbDriver}.password")
		]);
		
		app()->bind('db',function() use(&$database){
			return $database;
		});
	}
}