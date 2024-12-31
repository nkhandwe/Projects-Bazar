<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVideos extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'video_url',
        'title',
        'description',
        'thumbnail',
        'duration',
        'position',
        'is_published',
    ];
}
