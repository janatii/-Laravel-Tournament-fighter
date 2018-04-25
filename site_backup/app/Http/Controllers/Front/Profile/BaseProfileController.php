<?php

namespace App\Http\Controllers\Front\Profile;

use App\Http\Controllers\Controller;
use App\Models\User;

class BaseProfileController extends Controller
{
    /**
     * @param $pseudo
     *
     * @return User
     */
    protected function loadUser($pseudo): ?User
    {
        return User::with('networks')->where('username', $pseudo)->firstOrFail();
    }
}