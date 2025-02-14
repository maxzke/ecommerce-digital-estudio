<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Producto extends Model
{
    use HasFactory;
    protected $table = 'productos';
    protected $fillable = ['tipo', 'nombre', 'descripcion', 'precio_base'];

    public function scopeProductos(Builder $query)
    {
        $query->where('tipo', 'producto');
    }
    public function scopeServicios(Builder $query)
    {
        $query->where('tipo', 'servicio');
    }
    public function imagenes()
    {
        return $this->hasMany(Imagen::class, 'producto_id');
    }
    public function variaciones()
    {
        return $this->hasMany(ProductoVariacion::class, 'producto_id');
    }
    public function categorias()
    {
        return $this->belongsToMany(Categoria::class, 'categoria_produto', 'producto_id', 'categoria_id');
    }
}
