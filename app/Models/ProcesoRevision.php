<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProcesoRevision extends Model
{
    use HasFactory;
    protected $table = 'notas_proceso_revision';
    protected $fillable = [
        'nota_detalle_id',
        'revisado',
        'alerta'
    ];
    public function detalle()
    {
        return $this->belongsTo(NotaDetalle::class, 'nota_detalle_id');
    }
}
