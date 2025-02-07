<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;
    protected $fillable = ['nombre', 'descripcion', 'precio_base'];

    public function imagenes()
    {
        return $this->hasMany(Imagen::class);
    }
    public function variaciones()
    {
        return $this->hasMany(ProductoVariacion::class);
    }
    public function atributos()
    {
        return $this->belongsToMany(Atributo::class, 'atributo_valor_producto', 'producto_id', 'atributo_id');
    }
}
