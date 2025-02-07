<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProcesoInformacion extends Model
{
    use HasFactory;
    protected $table = 'notas_proceso_informacion';
    protected $fillable = [
        'nota_detalle_id',
        'informacion'
    ];
    public function detalle()
    {
        return $this->belongsTo(NotaDetalle::class, 'nota_detalle_id');
    }
}
