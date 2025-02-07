<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PagoDetalle extends Model
{
    use HasFactory;
    protected $table = "pagos_a_proveedor_detalle";
    protected $fillable = [
        'pagos_a_proveedor_id',
        'concepto',
        'cantidad',
        'precio'
    ];
    public function pagos()
    {
        return $this->belongsTo(PagoAProveedor::class, 'pagos_a_proveedor_id');
    }
    protected $appends = [
        'iva',
        'subtotal',
        'total'
    ];
    public function getIvaAttribute()
    {

        return ($this->precio * $this->cantidad) * 0.16;
    }
    public function getSubtotalAttribute()
    {
        return $this->importe - (($this->precio * $this->cantidad) * 0.16);
    }
    public function getTotalAttribute()
    {
        return $this->cantidad * $this->precio;
    }
    protected function concepto(): Attribute
    {
        return Attribute::make(
            set: fn(string $value) => strtolower($value),
        );
    }
}
