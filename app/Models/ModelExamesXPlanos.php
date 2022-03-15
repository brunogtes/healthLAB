<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelExamesXPlanos extends Model
{
    use HasFactory;
    protected $table = 'examexplano';
    protected $fillable = ['examexplano'];
    protected $primaryKey = 'id'; 
    public $timestamps = false;
}
