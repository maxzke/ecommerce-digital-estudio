<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AtributoValor extends Model
{
    use HasFactory;
    protected $table = 'atributo_valores';
    protected $fillable = ['atributo_id', 'valor'];

    public function atributo()
    {
        return $this->belongsTo(Atributo::class, 'atributo_id');
    }
}
