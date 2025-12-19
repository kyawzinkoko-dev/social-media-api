<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserRepository
{
   
    public function create(array $data): User
    {
        $data['password'] = Hash::make($data['password']);
        return User::create($data);
    }

    
    public function findByEmail(string $email): ?User
    {
        return User::where('email', $email)->first();
    }

  
    public function findById(int $id): ?User
    {
        return User::find($id);
    }

   
    public function getUserWithCounts(int $userId): ?User
    {
        return User::withCount(['posts', 'comments', 'reactions'])
            ->find($userId);
    }
}
