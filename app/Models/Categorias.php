<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categorias extends Model
{
    use HasFactory;
    protected $table = 'categorias';
    protected $primaryKey = "id_categoria";
    protected $guarded = [];

    protected function nombreCategoria(): Attribute 
    {
        return new Attribute(
            get: function($value){
                return ucfirst($value);
            },
            set: function($value) {
                return strtolower($value);
            }
        );
    }
}
