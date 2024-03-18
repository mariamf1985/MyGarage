<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coche extends Model
{
    use HasFactory;
    protected $guarded = [];


    /**
     * Define la relación entre Coche y Cliente.
     */
    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }

    /**
     * Define la relación entre Coche y Cita.
     */
    public function citas()
    {
        return $this->hasMany(Cita::class, 'id_car');
    }
}
