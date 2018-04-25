<?php

namespace App\Models;

use App\Models\Traits\HasUploadableAttributes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Intervention\Image\Constraint;
use Intervention\Image\Facades\Image;

class Game extends Model
{
    use HasUploadableAttributes;
    
    protected $fillable = [
        'name',
        'subdomain',
        'order',
    ];
    
    protected $uploadables = [
        'logo',
        'menu_logo',
        'banner',
        'logo_list_trainings',
    ];
    
    public function platform()
    {
        return $this->belongsTo(Platform::class);
    }
    
    public function network()
    {
        return $this->belongsTo(Network::class);
    }
    
    public function maps()
    {
        return $this->hasMany(Map::class);
    }
    
    public function gamemodes()
    {
        return $this->hasMany(Gamemode::class);
    }
    
    public function teams()
    {
        return $this->hasMany(Team::class);
    }
    
    public function matches()
    {
        return $this->hasMany(Match::class);
    }
    
    public function users()
    {
        return $this->belongsToMany(User::class, 'game_infos')->withTimestamps()->withPivot(['score', 'win', 'lost']);
    }
    
    public function getBoListArray()
    {
        if (empty($this->attributes['bo_list'])) {
            return [];
        }
        return explode(',', $this->attributes['bo_list']);
    }
    
    public function getBoListArrayWithText()
    {
        $boList = $this->getBoListArray();
        $newBoList = [];
        foreach ($boList as $key => $bo) {
            $newBoList[$bo] = bestof_text($bo);
        }
        return $newBoList;
    }
    
    public function getVsListArray()
    {
        if (empty($this->attributes['vs_list'])) {
            return [];
        }
        return explode(',', $this->attributes['vs_list']);
    }
    
    public function getVsListArrayWithText()
    {
        $vsList = $this->getVsListArray();
        $newVsList = [];
        foreach ($vsList as $key => $vs) {
            $newVsList[$vs] = versus_text($vs);
        }
        return $newVsList;
    }
    
    public function getMaxVs()
    {
        return max($this->getVsListArray());
    }
    
    public function getMaxBo()
    {
        return max($this->getBoListArray());
    }
    
    public function getLogoAttribute()
    {
        return $this->getUploadableAttribute('logo');
    }
    
    public function setLogoAttribute(UploadedFile $file)
    {
        $img = Image::make($file);
        $img->resize(null, 100, function (Constraint $constraint) {
            $constraint->aspectRatio();
        });
        $this->setUploadableAttribute('logo', $img);
    }
    
    public function getMenuLogoAttribute()
    {
        return $this->getUploadableAttribute('menu_logo');
    }
    
    public function setMenuLogoAttribute(UploadedFile $file)
    {
        $img = Image::make($file);
        $img->resize(null, 100, function (Constraint $constraint) {
            $constraint->aspectRatio();
        });
        $this->setUploadableAttribute('menu_logo', $img);
    }
    
    public function getBannerAttribute()
    {
        return $this->getUploadableAttribute('banner');
    }
    
    public function setBannerAttribute(UploadedFile $file)
    {
        $img = Image::make($file);
        $this->setUploadableAttribute('banner', $img);
    }
    
    public function getLogoListTrainingsAttribute()
    {
        return $this->getUploadableAttribute('logo_list_trainings');
    }
    
    public function setLogoListTrainingsAttribute(UploadedFile $file)
    {
        $img = Image::make($file);
        $this->setUploadableAttribute('logo_list_trainings', $img);
    }
    
    /**
     * @return Collection
     */
    public function getGamemodesByMapId()
    {
        return $this->maps->mapWithKeys(function (Map $map) {
            return [$map->id => $map->gamemodes];
        });
    }
    
    /**
     * @return Collection
     */
    public function getMapsByGamemodeId()
    {
        return $this->gamemodes->mapWithKeys(function (Gamemode $gamemode) {
            return [$gamemode->id => $gamemode->maps];
        });
    }
    
    /**
     * @return Collection
     */
    public function getClassicModesList()
    {
        $shortcutsList = explode(',', $this->classic_modes_list);
        $gamemodes = $this->gamemodes->keyBy('abbrev');
        
        $list = new Collection();
        foreach ($shortcutsList as $shortcut) {
            $list[] = $gamemodes[$shortcut];
        }
        return $list;
    }
    
    /**
     * @return Collection
     */
    public function getClassicModesSequenceIds()
    {
        return $this->getClassicModesList()->pluck('id');
    }
}
