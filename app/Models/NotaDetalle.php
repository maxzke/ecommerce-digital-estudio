<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotaDetalle extends Model
{
    use HasFactory;
    protected $table = "notas_detalle";
    protected $fillable = [
        'nota_id',
        'producto',
        'cantidad',
        'precio',
        'procentaje_descuento'
    ];

    protected $appends = [
        'total'
    ];

    public function getTotalAttribute()
    {
        $descuento_decimal = $this->procentaje_descuento / 10;
        $importe = floatval($this->cantidad) * floatval($this->precio);
        $descuento = $importe * $descuento_decimal;
        $total = $importe - $descuento;
        return floatval(number_format($total, 1,));
    }

    public function nota()
    {
        return $this->belongsTo(Nota::class, 'nota_id');
    }
    public function procesoTexto()
    {
        return $this->hasOne(ProcesoInformacion::class, 'nota_detalle_id');
    }
    public function procesoImagen()
    {
        return $this->hasOne(ProcesoRevision::class, 'nota_detalle_id');
    }
    public function procesoMaterial()
    {
        return $this->hasOne(ProcesoMaterial::class, 'nota_detalle_id');
    }
    public function procesoDiseno()
    {
        return $this->hasOne(ProcesoDiseno::class, 'nota_detalle_id');
    }
    public function procesoPrensa()
    {
        return $this->hasOne(ProcesoPrensa::class, 'nota_detalle_id');
    }
    public function procesoEntrega()
    {
        return $this->hasOne(ProcesoEntrega::class, 'nota_detalle_id');
    }
    protected function producto(): Attribute
    {
        return Attribute::make(
            set: fn(string $value) => strtolower($value),
        );
    }
}
