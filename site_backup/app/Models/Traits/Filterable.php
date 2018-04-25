<?php

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Builder;

trait Filterable
{
    public function scopeFilter(Builder $query, $filters)
    {
        foreach ($filters as $name => $value) {
            if (method_exists($this, 'scope' . ucfirst($name))) {
                $query = $query->scopes([$name => [$value]]);
            } else {
                $query = $query->where($name, $value);
            }
        }
        
        return $query;
    }
}
