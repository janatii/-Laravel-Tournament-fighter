<?php

namespace App\Http\Controllers\Admin\Users;

use App\Helpers\Facades\LocalizationFormats;
use App\Http\Requests\UserCreateRequest;
use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;

class CreateController extends BaseController
{
    public function page()
    {
        $roles = Role::all();
        
        return view('admin.users.create', compact('roles'));
    }
    
    public function save(UserCreateRequest $request)
    {
        $this->checkRolesAffectable($request->input('roles'));
        
        $user = new User();
        $user->username = $request->input('username');
        $user->firstname = $request->input('firstname');
        $user->lastname = $request->input('lastname');
        $user->birthdate = $request->input('birthdate') ? Carbon::createFromFormat(LocalizationFormats::getFormat('date'), $request->input('birthdate')) : null;
        $user->email = $request->input('email');
        if ($request->input('force_email_confirmation')) {
            $user->email_confirmed = date('Y-m-d H:i:s');
        }
        $user->password = bcrypt($request->input('password'));
        if ($request->hasFile('avatar')) {
            $user->avatar = $request->file('avatar');
        }
        $user->credits = $request->input('credits');
        $user->save();
        
        $user->roles()->attach($request->input('roles', []));
        
        return redirect()->route('admin_users_list')->with('success', trans('app.admin.users.created'));
    }
}
