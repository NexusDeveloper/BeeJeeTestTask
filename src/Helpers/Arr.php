<?php
declare(strict_types=1);
namespace Helpers;

/**
 * Class Arr
 * @package Helpers
 */
class Arr{
	/**
	 * @param array  $array
	 * @param string $key
	 *
	 * @return bool
	 */
	static public function has(array $array,string $key){
		if(!self::isChainOfKeys($array,$key))
			return isset($array[$key]);
		
		$chain=self::chainToArray($key);
		$key=array_pop($chain);
		$array=self::getNode($array,$chain);
		
		
		return !is_null($array) and isset($array[$key]);
	}
	
	/**
	 * @param array      $array
	 * @param string     $key
	 * @param mixed|null $default
	 *
	 * @return mixed|null
	 */
	static public function get(array $array,string $key,$default=null){
		$res=self::getNode(
			$array,
			self::chainToArray($key)
		);
		
		
		return is_null($res)?$default:$res;
	}
	
	/**
	 * @param array      $array
	 * @param string     $key
	 * @param mixed|null $value
	 */
	static public function set(array &$array,string $key,$value=null){
		if(!self::isChainOfKeys($array,$key)){
			$array[$key]=$value;
			
			return;
		};
		
		$chain=self::chainToArray($key);
		$key=array_pop($chain);
		$array=&self::getNode($array,$chain,false);
		if(is_null($value))
			unset($array[$key]);
		else
			$array[$key]=$value;
	}
	
	/**
	 * @param array $array
	 * @param array $chainOfKeys
	 * @param bool  $returnNullOnError
	 *
	 * @return array|mixed|null
	 */
	static protected function &getNode(array &$array,array $chainOfKeys,bool $returnNullOnError=true){
		foreach($chainOfKeys as $key){
			if(!isset($array[$key]) and $returnNullOnError){
				if($returnNullOnError)
					return null;
				
				$array[$key]=[];
			};
			
			$array=&$array[$key];
		};
		
		
		return $array;
	}
	
	/**
	 * @param array  $array
	 * @param string $key
	 *
	 * @return bool
	 */
	static public function isChainOfKeys(array $array,string $key):bool{
		return !isset($array[$key]) and mb_strpos($key,'.')!==false;
	}
	
	/**
	 * @param string $key
	 *
	 * @return array
	 */
	static public function chainToArray(string $key):array{
		return explode('.',$key);
	}
}