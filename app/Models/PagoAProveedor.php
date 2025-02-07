<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PagoAProveedor extends Model
{
    use HasFactory;
    protected $table = "pagos_a_proveedor";
    protected $fillable = [
        'proveedor_id',
        'user_id',
        'metodo_de_pago_id',
        'folio',
        'facturado'
    ];
    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class, 'proveedor_id');
    }
    public function metodo_de_pago()
    {
        return $this->belongsTo(MetodoPago::class, 'metodo_de_pago_id');
    }
    public function detalles()
    {
        return $this->hasMany(PagoDetalle::class);
    }
}
