<?php
declare(strict_types=1);
namespace App\Models;

use ActiveRecord\AbstractModel;

/**
 * Class User
 * @package App\Models
 *
 * @property int id
 * @property string login
 */
class User extends AbstractModel{
	protected static $tableName='users';
	protected static $timestamps=false;
}