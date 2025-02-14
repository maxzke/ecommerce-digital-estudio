<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class imagen extends Model
{
    use HasFactory;

    protected $filable = ['producto_id', 'url'];

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'producto_id');
    }
}
