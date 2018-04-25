<?php

namespace App\Http\Controllers\Admin\Wallet;

use App\Http\Controllers\Controller;
use App\Models\AskPayment;

class ListController extends Controller
{
    public function page()
    {
        $asks = AskPayment::with(['user'])->where('done', 0)->paginate(20);
        
        return view('admin.wallet.list', compact('asks'));
    }
    
    public function markDone(AskPayment $ask)
    {
        $ask->done = true;
        $ask->save();
        
        return back()->with(['success' => trans('app.admin.wallet.request-done')]);
    }
}
