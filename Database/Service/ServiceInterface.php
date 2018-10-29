<?php

namespace Database\Service;

interface ServiceInterface
{
    public function fetchById($id);
    public function save($instance);
    public function remove($instance);
}
