<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_rut',
        'component_id',
        'cantidad',
        'comentario',
        'estado'
    ];

    public function component() {
        return $this->belongsTo(Component::class);
    }    
}