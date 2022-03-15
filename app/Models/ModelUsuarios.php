<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class ModelUsuarios extends Model
{
    use HasFactory,Notifiable, HasRoles;
    
    protected $guard_name = 'usuarios';
    protected $table = 'usuarios';
    protected $fillable = ['usuarios'];
    protected $primaryKey = 'id'; 
    public $timestamps = false;
}
