<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nota extends Model
{
    use HasFactory;
    protected $table = "notas";
    protected $fillable = [
        'user_id',
        'cliente_id',
        'tipo', //['carrito','venta', 'cotizacion', 'cancelada',]
        'facturar',
        'finalizado',
        'detalles'
    ];
    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }
    public function usuario()
    {
        return $this->belongsTo(User::class);
    }
    public function productos()
    {
        return $this->hasMany(NotaDetalle::class);
    }
    public function abonos()
    {
        return $this->hasMany(Abono::class);
    }
    public function scopeCarrito(Builder $query)
    {
        $query->where('tipo', 'carrito');
    }
    //Devuelve solo las ventas
    public function scopeVentas(Builder $query)
    {
        $query->where('tipo', 'venta');
    }
    public function scopeCotizaciones(Builder $query)
    {
        $query->where('tipo', 'cotizacion');
    }
    public function scopeCanceladas(Builder $query)
    {
        $query->where('tipo', 'cancelada');
    }

    public static function getImporteTotalNota($productos)
    {
        $total = 0;
        foreach ($productos as $producto) {
            if ($producto->descuento > 0) {
                $procentaje_descuento = $producto->descuento / 100;
                $descuento = $procentaje_descuento * ($producto->precio * $producto->cantidad);
                $subtotal = ($producto->precio * $producto->cantidad) - $descuento;
                $total += $subtotal;
            } else {
                $total += $producto->precio * $producto->cantidad;
            }
        }
        return number_format($total, 2);
    }
}
