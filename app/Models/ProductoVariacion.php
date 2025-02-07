<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductoVariacion extends Model
{
    use HasFactory;

    protected $fillable = ['producto_id', 'precio_variacion', 'stock'];

    public function attributes()
    {
        return $this->belongsToMany(AtributoValor::class, 'producto_variacion_atributo_valor');
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }
}
