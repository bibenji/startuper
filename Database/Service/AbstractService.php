<?php

namespace Database\Service;

abstract class AbstractService implements ServiceInterface
{
	abstract protected function doUpdate($instance);
	abstract protected function doInsert($instance);
	abstract protected function flush($sql, $values, $where = '');
}
