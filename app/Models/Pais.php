<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Pais extends Model {

    use HasUlids;
    protected $table = 'pais';
    protected $primaryKey = 'PAIS_ID';
    public $timestamps = false;
    public $incrementing = false;
    public $keyType = 'string';

    protected $fillable = [
        'PAIS_ID',
        'PAIS_NOMBRE',
        'PAIS_ABREV',
        'PAIS_CODAREA',
        'PAIS_MONEDA',
        'PAIS_MONSIMBOLO',
        'PAIS_MONABREV',
        'PAIS_ESTADO',
    ];


    public function Insert(){
        DB::table($this->table)->insert($this->toArray());
    }
}
