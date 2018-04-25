<?php

namespace App\Http\Controllers\Auth;

use App\Exceptions\UserLockedException;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
        $this->middleware('gc_throttle:10,5', ['only' => 'login']);
    }
    
    /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  mixed $user
     * @return void
     * @throws UserLockedException
     */
    protected function authenticated(Request $request, $user)
    {
        if ($user->lock) {
            $this->guard()->logout();
    
            $request->session()->flush();
    
            $request->session()->regenerate();
            
            throw new UserLockedException();
        }
    }
    
    /**
     * Send the response after the user was authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function sendLoginResponse(Request $request)
    {
        $request->session()->regenerate();
        
        $this->clearLoginAttempts($request);
        
        $this->authenticated($request, $this->guard()->user());
        
        $path = session()->pull('url.intended', $this->redirectTo($request));
        
        if ($request->expectsJson()) {
            return response()->json(['redirect' => $path]);
        }
        return redirect()->to($path);
    }
    
    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        $this->guard()->logout();
        
        $request->session()->flush();
        
        $request->session()->regenerate();
        
        $redirectTo = $this->redirectTo($request);
        
        if (str_contains($redirectTo, '/admin/')) {
            $redirectTo = '/';
        }
        
        return redirect()->to($redirectTo);
    }
    
    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function username()
    {
        return 'username';
    }
    
    protected function redirectTo(Request $request)
    {
        return back()->getTargetUrl();
    }
}
