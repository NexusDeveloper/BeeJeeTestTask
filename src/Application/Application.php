<?php
declare(strict_types=1);
namespace Application;

use Config\Config;
use Container\Container;
use Container\Exceptions\ClassNotFoundException;
use Kernel\Interfaces\ServiceProvider;
use Request\Request;
use Router\Router;

class Application extends Container{
	protected $basePath;
	static protected $registeredProviders=[];
	
	/**
	 * Container constructor.
	 *
	 * @param string $basePath
	 */
	public function __construct(string $basePath){
		$this->basePath=rtrim($basePath,DIRECTORY_SEPARATOR);
		
		$this->registerBaseBindings();
	}
	
	/**
	 * @return void
	 */
	protected function registerBaseBindings():void{
		self::setInstance($this);
		$this->bind(Container::class,$this);
		$this->bind('app',$this);
		$this->bind('request',Request::class);
		$this->bind('config',Config::class);
		$this->bind('router',Router::class);
	}
	
	/**
	 * @param string|ServiceProvider $provider
	 */
	public function registerProvider($provider):void{
		if(is_string($provider))
			try{
				$provider=self::make($provider);
			}catch(ClassNotFoundException $exception){
				return;
			}
		
		if(!($provider instanceof ServiceProvider))
			return;
		
		$provider->register();
		self::markProviderAsRegistered($provider);
		foreach($provider->providers() as $item)
			$this->registerProvider($item);
	}
	
	/**
	 * @param ServiceProvider $provider
	 *
	 * @return bool
	 */
	static protected function isRegisteredProvider(ServiceProvider $provider):bool{
		return isset(self::$registeredProviders[get_class($provider)]);
	}
	
	/**
	 * @param ServiceProvider $provider
	 */
	static protected function markProviderAsRegistered(ServiceProvider $provider):void{
		static::$registeredProviders[get_class($provider)]=time();
	}
	
	/**
	 * @param string $path
	 *
	 * @return string
	 */
	public function basePath(string $path=''):string{
		return !$path?
			$this->basePath:
			$this->basePath.DIRECTORY_SEPARATOR.trim($path,DIRECTORY_SEPARATOR);
	}
	
	/**
	 * @param string $path
	 *
	 * @return string
	 */
	public function viewPath(string $path=''):string{
		$baseDir=config('app.directories.view','resources/view');
		if(empty($path))
			return (string) $baseDir;
		
		
		return $this->basePath(
			$baseDir.DIRECTORY_SEPARATOR.trim($path,DIRECTORY_SEPARATOR)
		);
	}
	
	/**
	 * @param string $path
	 *
	 * @return string
	 */
	public function publicPath(string $path=''):string{
		$baseDir=config('app.directories.public','public');
		if(empty($path))
			return (string) $baseDir;
		
		
		return $this->basePath(
			$baseDir.DIRECTORY_SEPARATOR.trim($path,DIRECTORY_SEPARATOR)
		);
	}
}