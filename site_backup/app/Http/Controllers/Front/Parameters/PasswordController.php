<?php

namespace App\Http\Controllers\Front\Parameters;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class PasswordController extends Controller
{
    public function page()
    {
        return view('front.parameters.password');
    }
    
    public function save(Request $request)
    {
        $this->validate($request, [
            'old_password' => 'required|current_password',
            'new_password' => 'required|confirmed|password',
        ]);
        
        $user = Auth::user();
        $user->password = bcrypt($request->new_password);
        $user->remember_token = Str::random(60);
        $user->save();
        
        return redirect()->back()->with('success', trans('app.front.parameters.password-changed'));
    }
}
