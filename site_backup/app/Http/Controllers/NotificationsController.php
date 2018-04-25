<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationsController extends Controller
{
    public function deleteOne(Request $request, $notifid)
    {
        Auth::user()->notifications()->findOrFail($notifid)->delete();

        return response()->json();
    }

    public function deleteAll(Request $request)
    {
        Auth::user()->notifications()->delete();

        return response()->json();
    }
}
