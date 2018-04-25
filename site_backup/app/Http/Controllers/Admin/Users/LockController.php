<?php

namespace App\Http\Controllers\Admin\Users;

use App\Models\User;

class LockController extends BaseController
{
    public function lock(User $user)
    {
        $user->lock = 1;
        $user->save();
        
        return redirect()->back()->with('success', trans('app.admin.users.locked'));
    }
    
    public function unlock(User $user)
    {
        $user->lock = 0;
        $user->save();
        
        return redirect()->back()->with('success', trans('app.admin.users.unlocked'));
    }
}
