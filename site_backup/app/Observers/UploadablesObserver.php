<?php

namespace App\Observers;

use Illuminate\Database\Eloquent\Model;

class UploadablesObserver
{
    public function saved(Model $entity)
    {
        foreach ($entity->getUploadables() as $field) {
            $value = $entity->getUploadableAttribute($field);
            if ($value === null) {
                $path = $entity->getStoragePath($field);
                if (file_exists($path) && is_file($path)) {
                    unlink($path);
                }
            } elseif ($value instanceof \Intervention\Image\Image) {
                $value->save($entity->getStoragePath($field));
            } elseif ($value instanceof \Illuminate\Http\UploadedFile) {
                $value->storePubliclyAs(dirname($entity->getStoragePath($field)), $entity->id);
            }
        }
    }
    
    public function deleted(Model $entity)
    {
        foreach ($entity->getUploadables() as $field) {
            $path = $entity->getStoragePath($field);
            if (file_exists($path) && is_file($path)) {
                unlink($path);
            }
        }
    }
}