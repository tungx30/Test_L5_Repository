<?php

namespace Packages\Auth\Models;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Foundation\Auth\User as Authenticable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Webpatser\Uuid\Uuid;

class Account extends Authenticable implements JWTSubject, CanResetPasswordContract
{
    use SoftDeletes, HasApiTokens, Authenticatable, Notifiable, HasRoles;

    public $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'name',
        'email',
        'password',
        'account_type',
        'account_id',
        'reset_password_token'
    ];

    protected $hidden = ['password', 'deleted_at', 'account_type', 'account_id'];

    protected $casts = [];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->{$model->getKeyName()} = Uuid::generate(4)->string;
        });
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    /**
     * Liên kết với bảng khác theo Morph
     */
    public function accountDetail()
    {
        return $this->morphTo(__FUNCTION__, 'account_type', 'account_id');
    }
    

}

