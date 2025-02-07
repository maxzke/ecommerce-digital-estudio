<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Abono extends Model
{
    use HasFactory;
    protected $table = 'abonos';
    protected $fillable = [
        'nota_id',
        'user_id',
        'metodo_de_pago_id',
        'importe'
    ];
    public function nota()
    {
        return $this->belongsTo(Nota::class, 'nota_id');
    }
    public function metodo_de_pago()
    {
        return $this->belongsTo(MetodoPago::class, 'metodo_de_pago_id');
    }
    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
