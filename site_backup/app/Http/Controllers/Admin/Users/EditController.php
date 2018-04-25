<?php

namespace App\Http\Controllers\Admin\Users;

use App\Helpers\Facades\LocalizationFormats;
use App\Helpers\TokenRepository;
use App\Http\Requests\UserEditRequest;
use App\Models\Role;
use App\Models\User;
use App\Notifications\ConfirmEmailNotification;
use Carbon\Carbon;
use Illuminate\Support\Str;

class EditController extends BaseController
{
    public function page(User $user)
    {
        $roles = Role::all();
        
        return view('admin.users.edit', compact('roles', 'user'));
    }
    
    public function sendConfirmationEmail(User $user)
    {
        if ($user->email_confirmed === null) {
            $tokenRepo = new TokenRepository('email_confirms');
            $token = $tokenRepo->create($user);
            
            $user->notify(new ConfirmEmailNotification($token));
            
            return redirect()->back()->with('success', trans('app.admin.users.confirmation-email-sent'));
        }
        
        return redirect()->back()->withErrors(['email' => trans('app.admin.users.email-already-confirmed')]);
    }

    public function save(UserEditRequest $request, User $user)
    {
        $this->checkRolesAffectable($request->input('roles'));
        
        $user->username = $request->input('username');
        $user->firstname = $request->input('firstname');
        $user->lastname = $request->input('lastname');
        $user->birthdate = $request->input('birthdate') ? Carbon::createFromFormat(LocalizationFormats::getFormat('date'), $request->input('birthdate')) : null;
        if ($user->email != $request->input('email')) {
            $user->email = $request->input('email');
            $user->email_confirmed = null;
        }
        if ($request->input('force_email_confirmation')) {
            $user->email_confirmed = date('Y-m-d H:i:s');
        }
        if ($request->input('password')) {
            $user->password = bcrypt($request->input('password'));
            $user->remember_token = Str::random(60);
        }
        if ($request->hasFile('avatar')) {
            $user->avatar = $request->file('avatar');
        }
        $user->credits = $request->input('credits');
        
        $user->save();
    
        $user->roles()->sync($request->input('roles', []));

        return redirect()->back()->with('success', trans('app.admin.users.updated'));
    }
    
    public function deleteAvatar(User $user)
    {
        $user->avatar = null;
        $user->save();
        
        return redirect()->back()->with('success', trans('app.admin.users.avatar-deleted'));
    }
}
