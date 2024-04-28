<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalidasVentas extends Model
{
    use HasFactory;
    protected $table = 'salidas_ventas';
    protected $primaryKey = 'id_salida_venta';
    protected $guarded = [];
}
