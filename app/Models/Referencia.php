<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Referencia extends Model{

    protected $table = 'referencia';
    protected $primaryKey = 'REFE_ID';
    public $timestamps = false; // Si no necesitas campos created_at y updated_at

    protected $fillable = [
        'SOLI_ID',
        'REFE_NOMBRES',
        'REFE_DIRECCION',
        'REFE_PARENTESCO',
        'REFE_TELEFONO',
        'REFE_DUI',
        'REFE_MAIL',
    ];

    public function solicitud() {
        return $this->belongsTo(Solicitud::class, 'SOLI_ID', 'SOLI_ID');
    }
}
