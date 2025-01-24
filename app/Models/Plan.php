<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Plan extends Model
{
    protected $fillable = [
        'external_id',
        'name',
        'quantity_instance',
        'quantity_messages',
        'price',
        'is_active',
    ];

    protected $appends = [
        'status',
        'price_parsed',
    ];

    public function clients(): HasMany
    {
        return $this->hasMany(Client::class);
    }

    public function status(): Attribute
    {
        return new Attribute(
            get: function () {
                return $this->attributes['is_active'] ? 'Ativo' : 'Inativo';
            }
        );
    }

    public function priceParsed(): Attribute
    {
        return new Attribute(
            get: function() {
                $fmt = numfmt_create('pt_BR', \NumberFormatter::CURRENCY);

                return numfmt_format_currency(
                    $fmt,
                    $this->attributes['price'],
                    'BRL'
                );
            }
        );
    }
}
