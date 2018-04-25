<?php

namespace App\Helpers;

use App\Models\User;
use Illuminate\Auth\Passwords\DatabaseTokenRepository;
use Illuminate\Support\Str;

class TokenRepository
{
    public function __construct($table)
    {
        $key = config('app.key');
        $connection = config('database.default');
        
        if (Str::startsWith($key, 'base64:')) {
            $key = base64_decode(substr($key, 7));
        }
        
        $this->repository = new DatabaseTokenRepository(
            app('db')->connection($connection),
            app('hash'),
            $table,
            $key,
            60
        );
    }
    
    public function create(User $user)
    {
        return $this->repository->create($user);
    }
    
    public function exists(User $user, $token)
    {
        return $this->repository->exists($user, $token);
    }
    
    public function delete(User $user)
    {
        $this->repository->delete($user);
    }
}
