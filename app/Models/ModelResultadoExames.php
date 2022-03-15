<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelResultadoExames extends Model
{
    protected $table = 'resultado_exames';
    protected $fillable = ['resultado_exames'];
    protected $primaryKey = 'resultado_exame_id';
    public $timestamps = false;
}
