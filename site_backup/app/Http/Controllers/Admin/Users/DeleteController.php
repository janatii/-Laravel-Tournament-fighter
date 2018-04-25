<?php

namespace App\Http\Controllers\Admin\Users;

use App\Models\User;

class DeleteController extends BaseController
{
    public function delete(User $user)
    {
        $user->delete();
        
        return redirect()->back()->with('success', trans('app.admin.users.deleted'));
    }
}
