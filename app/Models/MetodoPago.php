<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MetodoPago extends Model
{
    use HasFactory;
    protected $table = 'metodos_de_pago';
    protected $fillable = [
        'nombre'
    ];
    public function pagos()
    {
        return $this->hasMany(PagoAProveedor::class, 'metodo_de_pago_id');
    }
    public function abonos()
    {
        return $this->hasMany(Abono::class, 'metodo_de_pago_id');
    }
}
