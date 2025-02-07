<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProcesoEntrega extends Model
{
    use HasFactory;
    protected $table = 'notas_proceso_entrega';
    protected $fillable = [
        'nota_detalle_id',
        'entregado',
        'alerta'
    ];
    public function detalle()
    {
        return $this->belongsTo(NotaDetalle::class, 'nota_detalle_id');
    }
}
