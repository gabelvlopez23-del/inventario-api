<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    // Esto le permite a Laravel guardar los datos masivamente desde los formularios o Postman
    protected $fillable = [
        'nombre', 
        'precio', 
        'stock'
    ];
}
