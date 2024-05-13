<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PerdidasCredito extends Model
{
    use HasFactory;
    protected $table = 'perdidas_credito';
    protected $primaryKey = "id_perdida_credito";
    protected $guarded = [];
}
