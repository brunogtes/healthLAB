<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelPlano extends Model
{
    use HasFactory;

    protected $table = 'planos';
    protected $fillable = ['planos'];
   
    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'plano_id';

    public $timestamps = false;
}
