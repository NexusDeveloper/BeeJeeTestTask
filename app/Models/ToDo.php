<?php
declare(strict_types=1);
namespace App\Models;

use ActiveRecord\AbstractModel;
use App\Services\ToDoSortingService;

/**
 * Class ToDo
 * @package App\Models
 *
 * @property int $id
 * @property string $author_name
 * @property string $author_email
 * @property string $text
 * @property int $completed
 */
class ToDo extends AbstractModel{
	protected static $tableName='todo';
	
	/**
	 * @param array $where
	 * @param int   $quantity
	 * @param int   $offset
	 *
	 * @return array
	 */
	static public function search(array $where,int $quantity,int $offset):array{
		if(!isset($where['ORDER']))
			$where['ORDER']=[
				ToDoSortingService::getSortType()=>'ASC'
			];
		
		return parent::search($where,$quantity,$offset);
	}
}