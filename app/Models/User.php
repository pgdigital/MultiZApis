<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Notifications\SendResetPasswordNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Str;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $appends = ['avatar_url'];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function($user) {
            if(!$user->password) {
                $user->password = Str::random(16);
            }
        });
    }

    public function sendPasswordResetNotification($token)
    {
        $url = route('password.reset', $token);
        
        $this->notify(new SendResetPasswordNotification($url));
    }

    public function client(): HasOne
    {
        return $this->hasOne(Client::class);
    }

    public function avatarUrl(): Attribute
    {
        return new Attribute(
            get: function() {
                return 'https://ui-avatars.com/api/?name='.urlencode($this->attributes['name']).'&color=7F9CF5&background=EBF4FF';
            }
        );
    }

    public function isSuperAdmin(): bool
    {
        return $this->hasRole('Super Administrador');
    }
}
