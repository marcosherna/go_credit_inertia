<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perfil extends Model
{
    protected $table = 'perfil';
    public $timestamps = false; // Si no necesitas campos created_at y updated_at 
    protected $primaryKey = 'PERF_ID';
    public $incrementing = false;
    public $keyType = 'string';

    protected $fillable = [
        'PERF_ID',
        'PERF_NOMBRE',
        'PERF_ESTADO',
    ];

    public function usuarios() {
        return $this->hasMany(Usuario::class, 'PERF_ID', 'PERF_ID');
    }
}
