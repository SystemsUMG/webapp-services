<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthLoginRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public $response;
    public $message;
    public $result;
    public $records;
    public $statusCode;

    public function __construct()
    {
        $this->response = New ResponseController();
        $this->message = 'Bienvenido(a)';
        $this->result = true;
        $this->records = [];
        $this->statusCode = 200;
    }

    public function login(AuthLoginRequest $request)
    {
        $credentials = $request->validated();
        if (!auth()->attempt($credentials)) {
            $this->message = 'Credenciales incorrectas';
            $this->statusCode = 401;
            $this->result = false;
        } else {
            $user = User::where('email', $request->email)->firstOrFail();
            $token = $user->createToken('auth-token');

            $this->records = [
                'user_id' => $user->id,
                'name' => $user->name,
                'token' => $token->plainTextToken,
            ];
        }

        return $this->response->jsonResponse($this->records, $this->result, $this->message, $this->statusCode);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        Auth::user()->tokens()->delete();

        $this->message = 'Se ha cerrado la sesión';
        return $this->response->jsonResponse($this->records, $this->result, $this->message, $this->statusCode);
    }
}
