<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Garantia extends Model{
    protected $table = 'garantia';
    protected $primaryKey = 'GARA_ID';
    public $timestamps = false; // Si no necesitas campos created_at y updated_at

    protected $fillable = [
        'GARA_ID',
        'GARA_NOMBRE',
        'GARA_ESTADO',
    ];
}
