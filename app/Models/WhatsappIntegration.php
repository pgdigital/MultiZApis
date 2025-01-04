<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WhatsappIntegration extends Model
{
    protected $fillable = [
        "base_url",
        "token",
        "is_active"
    ];

    protected $casts = [
        "is_active" => "boolean"
    ];
}
