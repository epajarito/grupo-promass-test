<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Enums\Roles;
use App\Traits\Imageable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasApiTokens,
        HasFactory,
        Notifiable,
        SoftDeletes,
        Imageable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'telephone',
        'role',
        'last_name',
        'avatar',
        'last_login'
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
        'id' => 'string',
    ];


    /**
     *
     * Scope a query to only include active users.
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->whereNull('deleted_at');
    }

    /**
     * Function to check if the user is admin
     *
     * @return bool
    */
    public function isAdmin(): bool
    {
        return $this->role === Roles::Admin->value;
    }

    /**
     * Get the user's role label.
     *
     * @return string|null
    */
    public function getRolLabelAttribute(): ?string
    {
        return match ($this->role) {
            Roles::Admin->value => 'Administrador',
            Roles::User->value => 'Usuario',
            default => null,
        };
    }

    /**
     * Set the user's avatar.
     *
     * @param bool $remove
     * @return void
    */
    public function setAvatar(bool $remove = false): void
    {
        if (request()->file('avatar')) {
            if ($remove) {
                $this->remove($this->avatar);
            }
            $this->avatar = $this->upload(request()->file('avatar'), "users/avatars");
            $this->save();
        }
    }

    /**
     * Set the user's last login.
     *
     * @return void
    */
    public function setLastLogin(): void
    {
        $this->update([
            'last_login' => now()
        ]);
    }

    /**
     * Accessor for the user's full name.
     *
     * @return string
    */
    public function getFullNameAttribute(): string
    {
        return "{$this->name} {$this->last_name}";
    }

    /**
     * Accessor for the user's avatar url.
     *
     * @return string|null
    */
    public function getAvatarUrlAttribute(): ?string
    {
        return $this->avatar ? asset($this->avatar) : null;
    }
}
