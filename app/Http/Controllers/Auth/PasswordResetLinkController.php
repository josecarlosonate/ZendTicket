<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests\Auth\ForgotPasswordRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Password;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PasswordResetLinkController extends Controller
{
    public function create()
    {
        return view('auth.forgot-password');
    }

    public function store(ForgotPasswordRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $status = Password::sendResetLink([
            'email' => $data['email'],
        ]);

        if (in_array($status, [
            Password::INVALID_USER,
            Password::RESET_THROTTLED,
        ], true)) {
            return back()
                ->withErrors([
                    'error' => 'No fue posible procesar la solicitud.',
                ])
                ->onlyInput('email');
        }

        return back()->with(
            'status',
            'Te hemos enviado las instrucciones para restablecer tu contraseña.'
        );
    }
}
