<?php
declare(strict_types=1);
namespace Kernel;

use Application\Application;
use ErrorHandler\Exceptions\FatalThrowableError;
use ErrorHandler\Interfaces\ErrorHandler;
use Kernel\Bootstrap\ComponentsRegister;
use Kernel\Bootstrap\ProviderRegister;
use Response\Interfaces\Response;

class Kernel{
	protected $app;
	
	protected $bootstrappers=[
		ComponentsRegister::class,
		ProviderRegister::class
	];
	
	/***
	 * Kernel constructor.
	 *
	 * @param Application $app
	 */
	public function __construct(Application $app){
		$this->app=$app;
	}
	
	/**
	 * @return Response
	 */
	public function handle():Response{
		$response=null;
		try{
			$this->bootstrap();
			
			$response=app('router')->dispatch();
			if(!($response instanceof Response))
				$response=response($response);
		}catch(\Exception $exception){
			$response=$exception;
		}catch(\Throwable $throwable){
			$response=new FatalThrowableError($throwable);
		};
		
		if($response instanceof \Exception){
			$this->reportException($response);
			$response=$this->renderException($response);
		};
		
		
		return $response;
	}
	
	/**
	 * @return void
	 */
	protected function bootstrap():void{
		foreach($this->bootstrappers as $provider)
			$this->app->registerProvider($provider);
	}
	
	/**
	 * @param \Exception $exception
	 */
	protected function reportException(\Exception $exception):void{
		app(ErrorHandler::class)->report($exception);
	}
	
	/**
	 * @param \Exception $exception
	 *
	 * @return Response
	 */
	protected function renderException(\Exception $exception):Response{
		return app(ErrorHandler::class)->render($exception);
	}
}