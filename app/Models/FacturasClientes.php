<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FacturasClientes extends Model
{
    use HasFactory;
    protected $table = 'facturas_clientes';
    protected $primaryKey = 'id_factura_cliente';
    protected $guarded = [];
}
