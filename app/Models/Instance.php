<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use App\Observers\InstanceObserver;


#[ObservedBy([InstanceObserver::class])]
class Instance extends Model
{
    protected $fillable = [
        'client_id',
        'name',
        'phone',
        'token',
        'status',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($instance) {
            $instance->token = (string) str()->uuid();
            $instance->status = 'Aguardando Ler QrCode';
        });
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }
}
