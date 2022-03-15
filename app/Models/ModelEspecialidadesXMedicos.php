<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelEspecialidadesXMedicos extends Model
{
    use HasFactory;
    protected $table = 'especialidadexmedico';
    protected $fillable = ['especialidadexmedico'];
    protected $primaryKey = 'id'; 
    public $timestamps = false;
}
