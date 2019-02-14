<?php
declare(strict_types=1);
namespace Router;

use Helpers\Arr;
use Router\Interfaces\Route;

abstract class AbstractRoute implements Route{
	protected $uri;
	protected $name;
	protected $parameters=[];
	private $matches=[];
	
	/**
	 * @return bool
	 */
	public function isCurrentRoute():bool{
		return $this->requestURIMatchesCurrentURI();
	}
	
	/**
	 * @return array
	 */
	public function parameters():array{
		return $this->match()->parameters;
	}
	
	/**
	 * @param string      $name
	 * @param mixed|null  $default
	 *
	 * @return mixed|null
	 */
	public function parameter(string $name,$default=null){
		return Arr::get($this->match()->parameters,$name,$default);
	}
	
	/**
	 * @return bool
	 */
	protected function requestURIMatchesCurrentURI():bool{
		return preg_match(
			$this->getURIAsRegularExpression(),
			app('request')->requestURI(),
			$this->matches
		)===1;
	}
	
	/**
	 * @return string
	 */
	protected function getURIAsRegularExpression():string{
		return sprintf(
			'#^%s$#ui',
			preg_replace(
				'#\{[^}]+\}#uim',
				'([^\/]+)',
				$this->uri
			)
		);
	}
	
	/**
	 * @return AbstractRoute
	 */
	protected function match():self{
		if(count($this->matches)<=1)
			return $this;
		
		$parameters=array_slice($this->matches,1);
		$parametersNames=[];
		preg_match('#\{([^}]+)\}#uim',$this->uri,$parametersNames);
		
		$this->parameters=array_combine(
			array_slice($parametersNames,1),
			$parameters
		);
		
		
		return $this;
	}
	
	/**
	 * @param string $name
	 *
	 * @return Route
	 */
	public function name(string $name):Route{
		$this->name=$name;
		
		return $this;
	}
	
	/**
	 * @param array $parameters
	 *
	 * @return string
	 */
	public function getURL(array $parameters=[]):string{
		if(!empty($parameters)){
			$keys=array_keys($parameters);
			$keys=array_map(function($key){
				return sprintf('{%s}',$key);
			},
				$keys);
			
			$url=str_replace($keys,$parameters,$this->uri);
		}else
			$url=$this->uri;
		
		
		return preg_replace('#\{[^}]+\}#uim',null,$url);
	}
}