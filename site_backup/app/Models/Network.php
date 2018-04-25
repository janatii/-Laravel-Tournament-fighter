<?php

namespace App\Models;

use App\Models\Traits\HasUploadableAttributes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Intervention\Image\Facades\Image;

class Network extends Model
{
    use HasUploadableAttributes;
    
    protected $fillable = [
        'name',
    ];
    
    protected $uploadables = [
        'logo',
    ];
    
    public function users()
    {
        return $this->belongsToMany(User::class)->withPivot('identifier')->withTimestamps();
    }
    
    public function games()
    {
        return $this->hasMany(Game::class);
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
