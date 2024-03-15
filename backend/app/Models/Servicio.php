<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Servicio extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'description'];

    /**
     * Define la relación muchos a muchos entre Servicio y Cita.
     */
    public function citas()
    {
        return $this->belongsToMany(Cita::class);
    }
}
