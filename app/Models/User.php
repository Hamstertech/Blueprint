<?php

namespace App\Models;

use App\Enums\UserTypeEnum;
use App\Interfaces\DropdownModel;
use App\QueryBuilders\UserQueryBuilder;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements DropdownModel, MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'last_login',
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
        'last_login' => 'datetime',
        'password' => 'hashed',
        'role' => UserTypeEnum::class,
    ];

    // --------------------------
    // QUERY BUILDER
    // --------------------------
    public static function query(): UserQueryBuilder
    {
        /** @var UserQueryBuilder $query */
        $query = parent::query();

        return $query;
    }

    public function newEloquentBuilder($query): UserQueryBuilder
    {
        return new UserQueryBuilder($query);
    }

    // --------------------------
    // HELPERS
    // --------------------------
    public function isAdmin(): bool
    {
        return $this->role->value === UserTypeEnum::Admin->value;
    }

    public function isGuest(): bool
    {
        return $this->role->value === UserTypeEnum::Guest->value;
    }

    // --------------------------
    // INTERFACES
    // --------------------------
    public function getDropdownValue(): mixed
    {
        return $this->id;
    }

    public function getDropdownText(): string
    {
        return $this->name;
    }
}
