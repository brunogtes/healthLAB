<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelFuncionarios extends Model
{
    use HasFactory;
    protected $table = 'funcionarios';
    protected $fillable = ['funcionarios'];
    protected $primaryKey = 'id'; 
    public $timestamps = false;

}
