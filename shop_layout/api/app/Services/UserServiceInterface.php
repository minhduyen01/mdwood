<?php

namespace App\Services;

interface UserServiceInterface
{
    public function create($params);

    public function update($params, $id);

    public function countUserRegisterOnDay();
}
