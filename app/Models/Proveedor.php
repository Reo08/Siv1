<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    use HasFactory;
    protected $table = 'proveedor';
    protected $primaryKey = 'id_proveedor';
    protected $guarded = [];


    protected function nombreProveedor(): Attribute
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
    protected function correoProveedor(): Attribute
    {
        return new Attribute(
            set:function($value){
                return strtolower($value);
            }
        );
    }
}
