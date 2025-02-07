<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProcesoDiseno extends Model
{
    use HasFactory;
    protected $table = 'notas_proceso_diseno';
    protected $fillable = [
        'nota_detalle_id',
        'subido',
        'alerta'
    ];
    public function detalle()
    {
        return $this->belongsTo(NotaDetalle::class, 'nota_detalle_id');
    }
}
