<?php

namespace App\Http\Controllers\Admin\Games;

use App\Models\Game;

class PublishController extends BaseController
{
    public function publish(Game $game)
    {
        $game->published = 1;
        $game->save();
        
        return redirect()->back()->with('success', trans('app.admin.games.published'));
    }
    
    public function unpublish(Game $game)
    {
        $game->published = 0;
        $game->save();
        
        return redirect()->back()->with('success', trans('app.admin.games.unpublished'));
    }
}
