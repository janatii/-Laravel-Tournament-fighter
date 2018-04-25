<?php

namespace App\Models\Traits;

trait HasUploadableAttributes
{
    protected $uploadablesFiles = [];
    
    public function getUploadables()
    {
        return $this->uploadables;
    }
    
    public function getUploadableAttribute($field)
    {
        if (array_key_exists($field, $this->uploadablesFiles)) {
            return $this->uploadablesFiles[$field];
        } elseif ($this->exists) {
            $path = $this->getStoragePath($field);
            if (file_exists($path) && is_file($path)) {
                return $this->getPublicPath($field);
            }
        }
        
        $defaultFilePath = $this->getDefaultStoragePath($field);
        copy($defaultFilePath, $this->getStoragePath($field));
        return $this->getPublicPath($field);
    }
    
    public function setUploadableAttribute($field, $value)
    {
        $this->uploadablesFiles[$field] = $value;
    }
    
    public function getDefaultStoragePath($field)
    {
        return storage_path(config("uploads.storage_path") . $this->getFilepathForField($field, 'default'));
    }
    
    public function getStoragePath($field)
    {
        return storage_path(config("uploads.storage_path") . $this->getFilepathForField($field, $this->id));
    }
    
    public function getPublicPath($field)
    {
        return asset(config("uploads.public_path") . $this->getFilepathForField($field, $this->id)) . '?' . $this->updated_at->timestamp;
    }
    
    public function getFilepathForField($field, $filename)
    {
        return strtolower($this->getTable()) . DIRECTORY_SEPARATOR . $field . DIRECTORY_SEPARATOR . $filename;
    }
}
