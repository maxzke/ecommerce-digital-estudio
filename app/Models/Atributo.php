<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Atributo extends Model
{
    use HasFactory;
    protected $table = 'atributos';
    protected $fillable = ['nombre'];

    public function valores()
    {
        return $this->hasMany(AtributoValor::class, 'atributo_id');
    }
}
