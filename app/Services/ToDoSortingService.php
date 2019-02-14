<?php
declare(strict_types=1);
namespace App\Services;

class ToDoSortingService{
	const AVAILABLE_SORT_TYPES=[
		'author_name'=>'Имени пользователя',
		'author_email'=>'Email пользователя',
		'completed'=>'Статусу'
	];
	
	/**
	 * @param string $sortType
	 *
	 * @return bool
	 */
	static public function setSortType(string $sortType):bool{
		if(!isset(self::AVAILABLE_SORT_TYPES[$sortType]))
			return false;
		
		app('session')->set(
			self::getSortTypeSessionKey(),
			$sortType
		);
		
		
		return true;
	}
	
	/**
	 * @return string
	 */
	static public function getSortType():string{
		return app('session')->get(
			self::getSortTypeSessionKey(),
			key(self::AVAILABLE_SORT_TYPES)
		);
	}
	
	/**
	 * @return string
	 */
	static protected function getSortTypeSessionKey():string{
		return 'todo-sort-type';
	}
}