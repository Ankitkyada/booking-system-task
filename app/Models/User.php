<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Support\Facades\Hash;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Traits\Uuids;


class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory;
    use Notifiable, Uuids;

    protected $table = 'tbl_users';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
    ];
    protected $dates = [
        'email_verified_at'
    ];
}
