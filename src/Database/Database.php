<?php
declare(strict_types=1);
namespace Database;

use Medoo\Medoo;

class Database extends Medoo{
	/**
	 * Database constructor.
	 *
	 * @param array $options
	 */
	public function __construct(array $options){
		parent::__construct($options);
		
		$this->exec('set names utf8');
	}
}