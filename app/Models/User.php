<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'username',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Scope para incluir todos los registros con los ids pasados en el argumento $ids
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param array $ids Ids de los modelos a incluir en el scope
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeIds($query, $ids)
    {
        foreach ($ids as $id) {
            $query = $query->orWhere('id', $id);
        }
        return $query;
    }

    public function permissions(): HasMany
    {
        return $this->hasMany(Permission::class);
    }

    /**
     * Include relationship to array response
     */
    public function toArray()
    {
        $data = parent::toArray();
        if ($this->permissions) {
            $data['permissions'] = $this->permissions;
        } else {
            $data['permissions'] = [];
        }
        return $data;
    }
}
