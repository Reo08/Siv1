<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Productos extends Model
{
    use HasFactory;
    protected $table = 'productos';
    protected $primaryKey = 'id_producto';
    protected $guarded = [];

    protected function nombreProducto(): Attribute
    {
        return new Attribute(
            get: function($value) {
                return ucfirst($value);
            }, 
            set: function($value){
                return strtolower($value);
            }
        );
    }

    protected function detallesProducto(): Attribute
    {
        return new Attribute(
            get: function($value){
                return ucfirst($value);
            },
            set: function($value){
                return strtolower($value);
            }
        );
    }
}
