<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelResultadoItensExame extends Model
{
    use HasFactory;
    protected $table = 'Itens_resultado';
    protected $fillable = ['Itens_resultado'];
    protected $primaryKey = 'id';
    public $timestamps = false;
}
