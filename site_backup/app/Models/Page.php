<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $fillable = [
        'title',
        'lang',
        'url',
        'content',
        'order',
    ];
    
    public function __toString()
    {
        return $this->title;
    }
}
