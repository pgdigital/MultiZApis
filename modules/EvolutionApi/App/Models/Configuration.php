<?php

namespace Modules\EvolutionApi\App\Models;

use App\Models\Instance;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Configuration extends Model
{
    use HasFactory;

    protected $fillable = [
        'identification',
        'api_url',
        'global_token_api',
        'quantity_instances',
        'is_active'
    ];

    protected $table = "evolution_api_configurations";

    protected $casts = [
        'is_active' => 'boolean'
    ];

    protected $appends = ['status'];

    public function instances(): MorphMany
    {
        return $this->morphMany(Instance::class, 'providerable');
    }

    public function status(): Attribute
    {
        return new Attribute(
            get: function() {
                return $this->is_active ? 'Ativo' : 'Inativo';
            }
        );
    }
}
