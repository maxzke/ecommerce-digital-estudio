<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductoVariacion extends Model
{
    use HasFactory;
    protected $table = 'producto_variaciones';
    protected $fillable = ['producto_id', 'precio_variacion', 'stock'];

    public function atributos()
    {
        return $this->belongsToMany(AtributoValor::class, 'producto_variacion_atributo_valor', 'producto_variacion_id', 'atributo_valor_id');
    }
    public function attributeValues()
    {
        return $this->belongsToMany(AtributoValor::class, 'producto_variacion_atributo_valor', 'producto_variacion_id', 'atributo_valor_id')
            ->withTimestamps();
    }
}
