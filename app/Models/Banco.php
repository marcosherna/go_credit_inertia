<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Banco extends Model {
    use HasUlids;
    protected $table = 'banco';
    protected $primaryKey = 'BANC_ID';
    public $timestamps = false;
    public $incrementing = false; // Para indicar que no es autoincremental
    protected $keyType = 'string'; // Tipo de la clave primaria

    protected $fillable = [
        'BANC_ID', 'BANC_NOMBRE', 'BANC_DETALLE', 'SUCU_ID', 'BANC_ESTADO',
    ];

    public function sucursal() {
        return $this->belongsTo(Sucursal::class, 'SUCU_ID', 'SUCU_ID');
    }

    public function Insert(){
        DB::table($this->table)->insert($this->toArray());
    }
}
