<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalidasPerdidasCredito extends Model
{
    use HasFactory;
    protected $table = "salidas_perdidas_credito";
    protected $primaryKey = "id_salida_perdida_credito";
    protected $guarded = [];
}
