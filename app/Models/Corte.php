<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Corte extends Model
{
    use HasFactory;
    protected $table = 'cortes';
    protected $fillable = [
        'user_id',
        'dinero_en_caja',
        'fecha_inicial',
        'fecha_final'
    ];
    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
