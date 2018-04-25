<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LocalizationController extends Controller
{
    public function changeLocale(Request $request)
    {
        $localeSelected = $request->route('selected_locale');
        
        Validator::validate(compact('localeSelected'), [
            'localeSelected' => 'required|locale',
        ]);
        
        $cookie = cookie('locale', $localeSelected);
        
        return redirect()->back()->cookie($cookie);
    }
}
