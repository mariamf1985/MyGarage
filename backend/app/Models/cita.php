<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cita extends Model
{
    use HasFactory;
    protected $guarded = [];



    public function coche()
    {
        return $this->belongsTo(Coche::class, 'id_car');
    }

    
    public function servicios()
    {
        return $this->belongsToMany(Servicio::class);
    }
}
