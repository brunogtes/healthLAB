<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelItensExames extends Model
{
    use HasFactory;

    protected $table = 'itens_exames';
    protected $primaryKey = 'item_exame_id';
    protected $fillable = ['itens_exames'];
    
            
    /**
     * The primary key for the model.
     *
     * @var string
     */
    

    public $timestamps = false;
}
