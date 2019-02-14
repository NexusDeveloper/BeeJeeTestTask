<?php
declare(strict_types=1);
namespace Session;

use Session\Interfaces\Session;

class Flash{
	/** @var Session $session */
	protected $session;
	
	/**
	 * Flash constructor.
	 *
	 * @param null|Session $session
	 */
	public function __construct(?Session $session=null){
		$this->session=$session?:app('session');
	}
	
	/**
	 * @param string|null $name
	 * @param mixed|null  $default
	 *
	 * @return mixed
	 */
	public function get(?string $name=null,$default=null){
		$res=$this->session->get(
			$name=$this->prepareName($name),
			$default
		);
		if(!is_null($res))
			$this->session->set($name,null);
		
		
		return $res;
	}
	
	/**
	 * @param string|null $name
	 * @param mixed  $value
	 *
	 * @return Flash
	 */
	public function set(?string $name=null,$value=null):self{
		$this->session->set(
			$this->prepareName($name),
			$value
		);
		
		return $this;
	}
	
	/**
	 * @param null|string $name
	 *
	 * @return string
	 */
	protected function prepareName(?string $name):string{
		return $name?'flash.'.$name:'flash';
	}
}