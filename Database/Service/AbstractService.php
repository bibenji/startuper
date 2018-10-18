<?php

namespace Database\Service;

use Database\Connection;

abstract class AbstractService implements ServiceInterface
{
	protected $connection;
	
	public function __construct(Connection $connection)
	{
		$this->connection = $connection;
	}
	
	abstract protected function doUpdate($instance);
	abstract protected function doInsert($instance);
	abstract protected function flush($sql, $values, $where = '');
}
