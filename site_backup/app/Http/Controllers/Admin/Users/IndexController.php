<?php

namespace App\Http\Controllers\Admin\Users;

use App\Http\Requests\UserIndexRequest;
use App\Models\User;

class IndexController extends BaseController
{
    public function index(UserIndexRequest $request)
    {
        $filters = [
            'staff' => [
                ['label' => trans('app.admin.users.list-filters-labels.all'), 'value' => null],
                ['label' => trans('app.admin.users.list-filters-labels.staff'), 'value' => 1],
                ['label' => trans('app.admin.users.list-filters-labels.users'), 'value' => 0],
            ],
            'lock' => [
                ['label' => trans('app.admin.users.list-filters-labels.all'), 'value' => null],
                ['label' => trans('app.admin.users.list-filters-labels.locked'), 'value' => 1],
                ['label' => trans('app.admin.users.list-filters-labels.unlocked'), 'value' => 0],
            ],
        ];
        
        $filtersValues = array_filter($request->only(array_keys($filters)), function ($v) {
            return $v !== null;
        });
        
        $users = User::query()
                     ->filter($filtersValues)
                     ->with('roles')
                     ->paginate(10);
        
        return view('admin.users.index', compact('users', 'filters'));
    }
}
