<?php
declare(strict_types=1);
namespace ActiveRecord;

use ActiveRecord\Traits\HasAttributes;
use Router\Exceptions\NotFoundHttpException;

abstract class AbstractModel{
	use HasAttributes;
	
	static protected $tableName;
	static protected $timestamps=true;
	
	/**
	 * AbstractModel constructor.
	 *
	 * @param array $attributes
	 */
	public function __construct(array $attributes=[]){
		$this->fill($attributes);
	}
	
	/**
	 * @param int $id
	 *
	 * @return static|null
	 */
	static public function find(int $id):?self{
		$res=app('db')->get(static::getTable(),'*',['id'=>$id]);
		if(!is_array($res))
			return null;
		
		return new static($res);
	}
	
	/**
	 * @param int $id
	 *
	 * @return static
	 * @throws NotFoundHttpException
	 */
	static public function findOrFail(int $id):self{
		$res=static::find($id);
		if(!$res)
			throw new NotFoundHttpException("Model with id [$id] not found");
		
		
		return $res;
	}
	
	/**
	 * @return static[]
	 */
	static public function all():array{
		$res=app('db')->select(static::getTable(),'*');
		if(!is_array($res))
			return [];
		
		return array_map(function($item){
			return new static($item);
		},$res);
	}
	
	/**
	 * @param int $quantity
	 * @param int $offset
	 *
	 * @return static[]
	 */
	static public function get(int $quantity,int $offset):array{
		return static::search([],$quantity,$offset);
	}
	
	/**
	 * @param array $where
	 * @param int   $quantity
	 * @param int   $offset
	 *
	 * @return static[]
	 */
	static public function search(array $where,int $quantity,int $offset):array{
		$res=app('db')->select(static::getTable(),'*',array_merge($where,[
			'LIMIT'=>[$offset, $quantity]
		]));
		if(!is_array($res) or empty($res))
			return [];
		
		
		return array_map(function($item){
			return new static($item);
		},isset($res[0])?$res:[$res]);
	}
	
	/**
	 * Finally all handled models
	 *
	 * @param int      $quantity
	 * @param callable $callback
	 *
	 * @return static[]
	 */
	static public function chunk(int $quantity,callable $callback):array{
		$page=0;
		$result=[];
		do{
			$list=static::get($quantity+1,$page++*$quantity);
			foreach($list as $model){
				$result[]=$model;
			};
			if($continue=count($list)>$quantity)
				array_pop($list);
			
			$callback($list);
		}while($continue);
		
		
		return $result;
	}
	
	/**
	 * @return int
	 */
	static public function count():int{
		$res=app('db')->count(
			static::getTable()
		);
		
		return is_numeric($res)?(int) $res:0;
	}
	
	/**
	 * @param array $attributes
	 *
	 * @return static
	 */
	public function update(array $attributes):self{
		return $this->save($attributes);
	}
	
	/**
	 * @param array $attributes
	 *
	 * @return static
	 */
	public function save(array $attributes=[]):self{
		if(!empty($attributes))
			$this->fill($attributes);
		
		$id=$this->getAttribute('id')?:null;
		if(is_null($id))
			return $this->createEntry();
			
		app('db')->update(static::getTable(),$this->getAttributes(),[
			'id'=>$id
		]);
		
		
		return $this;
	}
	
	/**
	 * @return string
	 */
	static protected function getTable():string{
		return static::$tableName?:'';
	}
	
	/**
	 * @return AbstractModel
	 */
	protected function createEntry():self{
		if(static::$timestamps)
			$this->setAttribute('created_at',time());
		
		($db=app('db'))->insert(
			static::getTable(),
			$this->getAttributes()
		);
		$this->setAttribute('id',$db->id());
		
		
		return $this;
	}
}