<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Client extends Model
{
    protected $fillable = [
        "user_id",
        "phone",
        "quantity_instance",
        "status",
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function instances(): HasMany
    {
        return $this->hasMany(Instance::class);
    }

    public function campaigns(): HasMany
    {
        return $this->hasMany(Campaign::class);
    }
}
