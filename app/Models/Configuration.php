<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Configuration extends Model
{
    protected $fillable = [
        'name',
        'logo_path',
        'favicon_path',
        'home_image_path',
    ];
}
