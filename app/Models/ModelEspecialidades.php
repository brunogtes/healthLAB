<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelEspecialidades extends Model
{
    use HasFactory;
    protected $table = 'especialidades_medicas';
    protected $fillable = ['especialidades_medicas'];
    protected $primaryKey = 'id'; 
    public $timestamps = false;
   
  
 
   
}
