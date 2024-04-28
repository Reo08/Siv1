<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ganancias extends Model
{
    use HasFactory;
    protected $table = 'ganancias';
    protected $primaryKey = 'id_ganancia';
    protected $guarded = [];
}
