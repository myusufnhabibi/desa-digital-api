<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthStoreRequest;
use App\Interfaces\AuthInterface;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    private AuthInterface $authRepository;

    public function __construct(AuthInterface $authRepository)
    {
        $this->authRepository = $authRepository;
    }

    public function login(AuthStoreRequest $request)
    {
        $data = $request->validated();

        return $this->authRepository->login($data);
    }

    public function logout(Request $request)
    {
        return $this->authRepository->logout();
    }

    public function me(Request $request)
    {
        return $this->authRepository->me();
    }
}
