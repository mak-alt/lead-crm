<?php

namespace App\Services\MediaLibrary;

use Spatie\MediaLibrary\MediaCollections\Models\Media;
use App\Models\Lead;
use Spatie\MediaLibrary\Support\PathGenerator\PathGenerator as BasePathGenerator;

class CustomPathGenerator implements BasePathGenerator
{
    public function getPath(Media $media) : string
    {
        if ($media->model_type == "App\Models\Lead") {
            return core()->currentWebsite()->domain. '/leads/' . $media->id. '/';
        }

        if ($media->model_type == "App\Models\User") {
            return 'users'. '/' . $media->id. '/';
        }

        if ($media->model_type == "App\Models\Task") {
            return core()->currentWebsite()->domain. '/tasks/' . $media->id. '/';
        }
        // if ($media instanceof Product) {
        //     return 'products/' . $media->id;
        // }
    }

    public function getPathForConversions(Media $media) : string
    {
        return $this->getPath($media) . 'conversions/';
    }

    public function getPathForResponsiveImages(Media $media): string
    {
        return $this->getPath($media) . 'responsive/';
    }
}