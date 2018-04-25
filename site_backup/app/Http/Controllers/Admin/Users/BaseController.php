<?php

namespace App\Http\Controllers\Admin\Users;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;

class BaseController extends Controller
{
    protected function checkRolesAffectable($roles)
    {
        $superadmin = Role::whereName('superadmin')->first();
        if (in_array($superadmin->id, $roles)) {
            if (!Auth::user()->isSuperadmin()) {
                abort(403);
            }
        }
    }
}
