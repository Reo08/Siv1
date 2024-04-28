<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perdidas extends Model
{
    use HasFactory;
    protected $table = 'perdidas';
    protected $primaryKey = 'id_perdida';
    protected $guarded = [];
}
