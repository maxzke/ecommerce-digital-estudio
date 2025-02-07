<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DepositoACuenta extends Model
{
    use HasFactory;
    protected $table = 'depositos_a_cuenta';
    protected $fillable = [
        'user_id',
        'metodo_de_pago_id',
        'importe',
        'detalles'
    ];
    public function usuario()
    {
        return $this->belongsTo(User::class);
    }
    public function metodo_de_pago()
    {
        return $this->belongsTo(MetodoPago::class, 'metodo_de_pago_id');
    }
}
