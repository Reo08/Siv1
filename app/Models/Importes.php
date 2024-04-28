<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Importes extends Model
{
    use HasFactory;
    protected $table = 'importes_pagados';
    protected $primaryKey = "id_importe";
    protected $guarded = [];
}
