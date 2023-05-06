<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserService implements UserServiceInterface
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function create($params)
    {
        $params['password'] = Hash::make($params['password']);
        return $this->user->create($params);
    }

    public function update($params, $id)
    {
        if (isset($params['password'])) {
            $params['password'] = Hash::make($params['password']);
        }
        return $this->user->findOrFail($id)->update($params);
    }

    public function countUserRegisterOnDay()
    {
        return $this->user->whereDate('created_at', '=', today()->toDateString())->get()->count();
    }
}
