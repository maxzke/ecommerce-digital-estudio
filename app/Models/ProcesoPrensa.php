<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProcesoPrensa extends Model
{
    use HasFactory;
    protected $table = 'notas_proceso_prensa';
    protected $fillable = [
        'nota_detalle_id',
        'en_proceso',
        'empaquetado',
        'enviado',
        'alerta'
    ];
    public function detalle()
    {
        return $this->belongsTo(NotaDetalle::class, 'nota_detalle_id');
    }
}
