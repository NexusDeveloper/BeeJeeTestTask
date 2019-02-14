<?php
declare(strict_types=1);
namespace Config;

use Helpers\Arr;

class Config{
	CONST CONFIG_DIRECTORY='config';
	
	static private $cache=[];
	
	protected $filePath;
	protected $config;
	
	/**
	 * Config constructor.
	 *
	 * @param string $fileName
	 */
	public function __construct(string $fileName){
		$this->filePath=base_path(self::CONFIG_DIRECTORY,$fileName);
	}
	
	/**
	 * @param string     $key
	 * @param mixed|null $default
	 *
	 * @return mixed|null
	 */
	public function get(string $key,$default=null){
		return Arr::get($this->load()->config,$key,$default);
	}
	
	/**
	 * @return Config
	 */
	protected function load():self{
		if(isset($cache[$this->filePath]))
			$this->config=&$cache[$this->filePath];
		
		if(!is_null($this->config))
			return $this;
		
		$config=[];
		if(is_file($this->filePath))
			$config=include $this->filePath;
		
		$cache[$this->filePath]=$config;
		$this->config=&$cache[$this->filePath];
		
		
		return $this;
	}
}