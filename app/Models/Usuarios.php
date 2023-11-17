<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class Usuarios extends Authenticatable {   
    
    use Notifiable, HasApiTokens, HasFactory,HasProfilePhoto, TwoFactorAuthenticatable;
    protected $table = 'usuarios';
    protected $primaryKey = 'USUA_LOGIN';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'USUA_LOGIN',
        'USUA_PASS',
        'PERF_ID',
        'EMPL_ID',
        'USUA_ESTADO',
    ];

    public function perfil() {
        return $this->belongsTo(Perfil::class, 'PERF_ID', 'PERF_ID');
    }

    public function empleado() {
        return $this->belongsTo(Empleado::class, 'EMPL_ID', 'EMPL_ID');
    }


}
