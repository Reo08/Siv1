<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalidasPerdidas extends Model
{
    use HasFactory;
    protected $table ='salidas_perdidas';
    protected $primaryKey = 'id_salida_perdida';
    protected $guarded = [];
}
