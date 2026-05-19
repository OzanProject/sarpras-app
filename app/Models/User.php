<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'is_approved',
        'photo',
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
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_approved' => 'boolean',
        ];
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function getRoleAttribute($value)
    {
        if ($this->relationLoaded('role')) {
            return $this->getRelation('role');
        }

        if (!empty($this->role_id)) {
            $roleObj = $this->role()->getResults();
            if ($roleObj) {
                return $roleObj;
            }
        }

        if (is_string($value) && !empty($value)) {
            $roleObj = Role::where('name', $value)->first();
            if ($roleObj) {
                $this->setRelation('role', $roleObj);
                return $roleObj;
            }
        }

        return null;
    }
}
