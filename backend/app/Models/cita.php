<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cita extends Model
{
    use HasFactory;
    protected $guarded = [];


    /**
     * Define la relación entre Cita y Coche.
     */
    public function coche()
    {
        return $this->belongsTo(Coche::class, 'id_car');
    }

    /**
     * Define la relación muchos a muchos entre Cita y Servicio.
     */
    public function servicios()
    {
        return $this->belongsToMany(Servicio::class);
    }
}
