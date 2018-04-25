<?php

namespace App\Http\Controllers\Front\Team;

use App\Http\Controllers\Controller;
use App\Models\Team;

class BaseTeamController extends Controller
{
    protected function loadTeam($teamname)
    {
        return Team::with('networks')->where('slug', str_slug($teamname))->firstOrFail();
    }
}