<?php

namespace App\Models;

use App\Models\ModelPlano;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelConvenios extends Model
{
    use HasFactory;

    protected $table = 'convenios';
    protected $fillable = ['convenios'];


    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    public $timestamps = false;
}
