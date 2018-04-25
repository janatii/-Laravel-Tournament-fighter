<?php

namespace App\Http\Controllers\Admin\Games\Maps;

use App\Models\Game;
use App\Models\Map;

class DeleteController extends BaseController
{
    public function delete(Game $game, Map $map)
    {
        $map->delete();
        
        return redirect()->back()->with('success', trans('app.admin.maps.deleted'));
    }
}
