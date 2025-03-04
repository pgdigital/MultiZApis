<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InstanceMessage extends Model
{
    protected $fillable = [
        'instance_id',
        'client_id',
        'number',
        'message',
    ];

    public function instance()
    {
        return $this->belongsTo(Instance::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
