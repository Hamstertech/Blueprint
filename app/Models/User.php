<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Enums\UserTypeEnum;
use App\Notifications\ResetPasswordNotification;
use App\QueryBuilders\UserQueryBuilder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Crypt;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
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
        'last_login',
        'user_type'
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
        'last_login' => 'datetime',
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'user_type' => UserTypeEnum::class,
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
    // RELATIONSHIPS
    // --------------------------

    // --------------------------
    // HELPERS
    // --------------------------
    public function isAdmin(): bool
    {
        return $this->user_type->value === UserTypeEnum::Admin->value;
    }

    public function isCustomer(): bool
    {
        return $this->user_type->value === UserTypeEnum::Customer->value;
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    // TODO:

    // --------------------------
    // Encryption
    // --------------------------
    // public function getEmailAttribute($value) {
    //     return Crypt::decryptString($value);
    // }

    // public function setEmailAttribute($value) {
    //     $this->attributes['email'] = Crypt::encryptString($value);
    // }
}
