<?php

namespace App\Http\Controllers\Front\Parameters;

use App\Helpers\TokenRepository;
use App\Http\Controllers\Controller;
use App\Notifications\ConfirmEmailNotification;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;

class EmailController extends Controller
{
    public function page()
    {
        $user = Auth::user();
        return view('front.parameters.email', ['user' => $user]);
    }
    
    public function sendConfirmationEmail()
    {
        $user = Auth::user();
        
        if ($user->email_confirmed === null) {
            $tokenRepo = new TokenRepository('email_confirms');
            $token = $tokenRepo->create($user);
            
            $user->notify(new ConfirmEmailNotification($token));
    
            return redirect()->back()->with('success', trans('app.front.parameters.confirmation-email-sent'));
        }
    
        return redirect()->back()->withErrors(['email' => trans('app.front.parameters.email-already-confirmed')]);
    }

    public function save(Request $request)
    {
        $user = Auth::user();

        $this->validate($request, [
            'password' => 'required|current_password',
            'email' => 'required|max:255|email|unique:users,email,' . $user->id,
        ]);

        if ($user->email != $request->email) {
            $user->email = $request->email;
            $user->email_confirmed = null;
            $user->save();
    
            $tokenRepo = new TokenRepository('email_confirms');
            $token = $tokenRepo->create($user);
            
            $user->notify(new ConfirmEmailNotification($token));

            return redirect()->back()->with('success', trans('app.front.parameters.email-changed'));
        }
        return redirect()->back()->with('success', trans('app.front.parameters.nothing-changed'));
    }

    public function confirm(Request $request)
    {
        $user = Auth::user();
        
        $tokenRepo = new TokenRepository('email_confirms');
        if ($tokenRepo->exists($user, $request->token)) {
            $tokenRepo->delete($user);

            $user->email_confirmed = Carbon::now();
            $user->save();

            session()->flash('success', trans('app.front.parameters.email-confirmed'));
            return redirect()->to('/parameters/email');
        }
        session()->flash('error', trans('app.front.parameters.unable-to-confirm-email'));
        return redirect()->to('/parameters/email');
    }
}
