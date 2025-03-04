<?php

namespace Packages\Auth\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Foundation\Auth\User as Authenticable;
use Illuminate\Notifications\Notifiable;
use Packages\User\Models\User;
use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Webpatser\Uuid\Uuid;

class Account extends Authenticable implements JWTSubject, CanResetPasswordContract
{
    use SoftDeletes, HasApiTokens, Authenticatable, Notifiable, HasRoles;

    public $keyType = 'string';
    public $incrementing = false;
    protected $guard_name = 'web';

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
        static::creating(function ($account) {
            // Nếu account_id rỗng, gán id của chính nó (cho User)
            if (empty($account->account_id)) {
                $account->account_id = $account->id;
            }
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
    public function user()
    {
        return $this->belongsTo(User::class, 'account_id');
    }
}
