<?php
declare(strict_types=1);
namespace Response;

class ResponseRedirect extends Response{
	protected $redirectUrl;
	protected $permanent=false;
	
	/**
	 * @param string $url
	 * @param bool   $permanent
	 *
	 * @return ResponseRedirect
	 */
	public function url(string $url,bool $permanent=false):self{
		$this->redirectUrl=$url;
		$this->permanent=$permanent;
		
		return $this;
	}
	
	/**
	 * @param bool $permanent
	 *
	 * @return ResponseRedirect
	 */
	public function back(bool $permanent=false):self{
		return $this->url(
			app('request')->server('HTTP_REFERER')?:'/',
			$permanent
		);
	}
	
	/**
	 * @param string $name
	 * @param array  $parameters
	 * @param bool   $permanent
	 *
	 * @return ResponseRedirect
	 */
	public function route(string $name,array $parameters=[],bool $permanent=false):self{
		return $this->url(
			url()->route($name,$parameters),
			$permanent
		);
	}
	
	/**
	 * @return void
	 */
	public function send(){
		header(
			'Location: '.$this->redirectUrl,
			true,
			$this->permanent?301:302
		);
	}
}