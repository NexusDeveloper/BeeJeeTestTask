<?php

class PHPViewParameters{
	private $params=[];
	protected $model;
	
	/**
	 * PHPViewHelper constructor.
	 *
	 * @param array $params
	 */
	public function __construct(array $params){
		$this->params=$params;
	}
	
	/**
	 * @param \ActiveRecord\AbstractModel $model
	 *
	 * @return PHPViewParameters
	 */
	public function setDataModel(\ActiveRecord\AbstractModel $model):self{
		$this->model=$model;
		
		return $this;
	}
	
	/**
	 * @param string $varName
	 *
	 * @return null|mixed
	 */
	public function get(string $varName){
		return \Helpers\Arr::get($this->params,$varName);
	}
	
	/**
	 * @param string $varName
	 */
	public function __invoke(string $varName){
		echo $this->escape(
			$this->get($varName)
		);
	}
	
	/**
	 * @param mixed $str
	 *
	 * @return mixed
	 */
	public function escape($str){
		if(is_scalar($str) and !empty($str))
			return htmlspecialchars((string) $str);
		
		if(is_array($str))
			return array_map([$this,'escape'],$str);
		
		
		return $str;
	}
	
	/**
	 * @param string $name
	 *
	 * @return mixed
	 */
	public function field(string $name){
		return $this->escape(
			$this->model?
				$this->model->getAttribute($name):
				app('flash')->get('form-data.'.$name)
		);
	}
}