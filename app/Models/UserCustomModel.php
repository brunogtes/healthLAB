<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class UserCustomModel extends Authenticatable
{

    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    protected $guard_name = 'usuarios';
    protected $fillable = ['nome', 'email', 'password', 'google_id', 'facebook_id'];
    protected $hidden = ['password'];
    protected $primaryKey = 'id';
    protected $table = "usuarios";
    public $timestamps = false;
}