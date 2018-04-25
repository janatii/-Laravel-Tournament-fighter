<?php

namespace App\Http\Controllers\Admin\Games;

use App\Models\Game;

class DeleteController extends BaseController
{
    public function delete(Game $game)
    {
        $game->delete();
        
        return redirect()->back()->with('success', trans('app.admin.games.deleted'));
    }
}
