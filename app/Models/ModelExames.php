<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelExames extends Model
{
   protected $table = 'tipo_exame';
   protected $fillable = ['tipo_exame'];
  
 

    /**
     * The primary key for the model.
     *
     * @var string
     */

    protected $primaryKey = 'id';

    public $timestamps = false;
}
