<?php

namespace App\Http\Controllers\Front\Parameters;

use App\Helpers\Facades\LocalizationFormats;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function page()
    {
        $user = Auth::user();
        $locales = LocalizationFormats::getAcceptedLocales();
        
        return view('front.parameters.index', compact('user', 'locales'));
    }

    public function save(Request $request)
    {
        $dateFormat = LocalizationFormats::getFormat('date');
        $user = Auth::user();
        
        $validationRules = [
            'firstname' => 'present|nullable|string|max:255',
            'lastname' => 'present|nullable|string|max:255',
            'birthdate' => 'present|nullable|date_format:' . $dateFormat . '|before:' . date('Y-m-d'),
            'language' => 'required|locale',
        ];
        
        if ($user->isPremium()) {
            $validationRules['username'] = 'required|string|min:4|max:15|alpha_dash|unique:users,username,' . $user->id;
        }

        $this->validate($request, $validationRules);
        
        if ($user->isPremium()) {
            $user->username = $request->input('username');
        }
        $user->firstname = $request->input('firstname');
        $user->lastname = $request->input('lastname');
        $user->birthdate = $request->input('birthdate') ? Carbon::createFromFormat($dateFormat, $request->input('birthdate')) : null;
        $user->locale = $request->input('language');
        $user->save();

        app()->setLocale($user->locale);
        
        return redirect()->back()->with('success', trans('app.front.parameters.updated'))->withCookie(cookie('locale', $user->locale));
    }
}
