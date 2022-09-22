<?php

namespace App\Traits;

use App\Models\Photo;

trait HasPhoto
{
    public static function bootHasPhoto()
    {
        static::deleting(function ($model) {
            $model->deleteImages();
        });
    }

    public function photo()
    {
        return $this->morphOne(Photo::class, 'photoable')->where('type', 'single');
    }

    public function gallery()
    {
        return $this->morphMany(Photo::class, 'photoable')->where('type', 'gallery');
    }

    public function photos()
    {
        return $this->morphMany(Photo::class, 'photoable');
    }

    public function storeImage($path, $type = 'single')
    {
        return $this->photo()->create(['path' => $path, 'type' => $type]);
    }

    public function updateImage($path, $type = 'single')
    {
        if ($type == 'single' && $this->photo) {
            $this->photo->delete();
        } else {
            $this->gallery->each(function ($photo) {
                $photo->delete();
            });
        }

        $this->storeImage($path, $type);
    }

    public function deleteImages()
    {
        $this->photos->each(function ($photo) {
            $photo->delete();
        });
    }

    public function getImageAttribute()
    {
        if (!$this->photo) {
            return null;
        }

        return asset('storage/' . $this->photo->path);
    }

    public function getImagesAttribute()
    {
        $photos = $this->gallery;

        if (!$photos || $photos->count()) {
            return collect([]);
        }

        return $photos->map(function ($photo){
            return $photo;
        });
    }
}