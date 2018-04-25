<?php

namespace App\Models;

use App\Models\Traits\HasUploadableAttributes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Intervention\Image\Facades\Image;

class Map extends Model
{
    use HasUploadableAttributes;
    
    protected $fillable = [
        'name',
    ];
    
    protected $uploadables = [
        'logo',
    ];
    
    public function game()
    {
        return $this->belongsTo(Game::class);
    }
    
    public function gamemodes()
    {
        return $this->belongsToMany(Gamemode::class, 'maps_gamemodes')->withTimestamps();
    }
    
    public function getLogoAttribute()
    {
        return $this->getUploadableAttribute('logo');
    }
    
    public function setLogoAttribute(UploadedFile $file)
    {
        $img = Image::make($file);
        $this->setUploadableAttribute('logo', $img);
    }
    
    public function __toString()
    {
        return $this->name;
    }
}
