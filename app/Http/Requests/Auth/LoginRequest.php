<?php

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Cache\RateLimiter;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException ;

class LoginRequest extends FormRequest
{
     
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules() {
        return [
            'USUA_LOGIN' => 'required',
            'USUA_PASS' => 'required',
        ];
    }

    public function Authenticate(){
        $limiter = app(RateLimiter::class);
        $this->ensureIsNotRateLimited();

        $credentials = $this->only('USUA_LOGIN', 'USUA_PASS'); 
        if (!auth()->attempt($credentials, $this->boolean('remember'))) {
            
            $limiter->hit($this->throttleKey()); 
            throw ValidationException::withMessages([
                'USUA_LOGIN' => __('auth.failed'),
            ]);
        }  
        $limiter->clear($this->throttleKey());
    }

    public function ensureIsNotRateLimited(){
        if(!RateLimiter::tooManyAttempts($this->throttleKey(), 5)){
            return;
        }

        event(new Lockout($this));

        throw ValidationException::withMessages([
            'USUA_LOGIN' => __('auth.throttle', [
                'seconds' => 60,
                'minutes' => ceil(60 / 60),
            ]),
        ]);
    }
}
