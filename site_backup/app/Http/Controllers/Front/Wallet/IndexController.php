<?php

namespace App\Http\Controllers\Front\Wallet;

use App\Http\Controllers\Controller;
use App\Models\AskPayment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function page()
    {
        $user = Auth::user();
        
        $askAlreadyExists = AskPayment::where('user_id', $user->id)->where('done', 0)->exists();
        
        return view('front.wallet.index', compact('user', 'askAlreadyExists'));
    }

    public function send(Request $request)
    {
        $user = Auth::user();

        $this->validate($request, [
            'credits' => 'required|int|min:50',
            'infos' => 'required|string|max:512',
        ]);
        
        $data = $request->only('credits', 'infos');
        $data['user_id'] = $user->id;
        AskPayment::create($data);
        
        return redirect()->back()->with('success', trans('app.front.wallet.sended'));
    }
}
