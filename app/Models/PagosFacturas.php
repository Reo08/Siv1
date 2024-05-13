<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PagosFacturas extends Model
{
    use HasFactory;
    protected $table = 'pagos_facturas';
    protected $primaryKey = 'id_pago_factura';
    protected $guarded = [];
}
