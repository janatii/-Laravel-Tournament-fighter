<?php

namespace App\Http\Controllers\Admin\Users;

use App\Models\User;

class ShowController extends BaseController
{
    public function page(User $user)
    {
        return view('admin.users.show', compact('user'));
    }
}
