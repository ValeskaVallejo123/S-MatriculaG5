<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    // Esto permite que updateOrCreate funcione
    protected $fillable = ['id', 'nombre']; 
}