<?php

namespace App\Models;

use App\Models\Traits\HasUploadableAttributes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Intervention\Image\Constraint;
use Intervention\Image\Facades\Image;

class Platform extends Model
{
    use HasUploadableAttributes;
    
    protected $fillable = [
        'name',
        'order',
    ];
    
    protected $uploadables = [
        'logo',
    ];
    
    public function games()
    {
        return $this->hasMany(Game::class)->orderBy('order');
    }
    
    public function getLogoAttribute()
    {
        return $this->getUploadableAttribute('logo');
    }
    
    public function setLogoAttribute(UploadedFile $file)
    {
        $img = Image::make($file);
        $img->resize(null, 50, function (Constraint $constraint) {
            $constraint->aspectRatio();
        });
        $this->setUploadableAttribute('logo', $img);
    }
    
    public function __toString()
    {
        return $this->name;
    }
}
