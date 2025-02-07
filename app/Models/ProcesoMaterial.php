<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProcesoMaterial extends Model
{
    use HasFactory;
    protected $table = 'notas_proceso_material';
    protected $fillable = [
        'nota_detalle_id',
        'solicitado',
        'disponible_en_almacen',
        'alerta'
    ];
    public function detalle()
    {
        return $this->belongsTo(NotaDetalle::class, 'nota_detalle_id');
    }
}
