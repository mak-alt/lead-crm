<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\MediaCollections\Models\Media as BaseMedia;

class Media extends BaseMedia
{
    use HasFactory;

    /**
     * Boot events
     * @return void
     */
    public static function boot()
    {
        parent::boot();

        static::creating(function ($media) {
            if (core()->currentWebsite()) {
                $media->website_id = core()->currentWebsite()->id;
            }
        });
    }

    /**
     * User relationship (one-to-one)
     * @return App\User
     */
    public function website()
    {
        return $this->belongsTo('App\Models\Media');
    }
}
