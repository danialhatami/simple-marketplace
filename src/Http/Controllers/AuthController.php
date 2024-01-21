<?php

namespace Danial\SimpleMarketplace\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Danial\SimpleMarketplace\Http\Requests\UserLoginRequest;
use Danial\SimpleMarketplace\Http\Requests\UserRegisterRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function register(UserRegisterRequest $request): JsonResponse
    {
        $validated = $request->validated();
        try {
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => bcrypt($validated['password']),
            ]);

            return response()->json([
                'message' => 'User Successfully created!',
                'accessToken' => $user->createToken('Token')->plainTextToken,
            ], Response::HTTP_CREATED);
        } catch (\Throwable $throwable) {
            report($throwable);
            return response()->json(
                [
                    'message' => 'Registering User Failed Successfully!'
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function login(UserLoginRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $credentials = request([$validated['email'], $validated['password']]);

        if (!Auth::attempt($credentials)) {
            abort(Response::HTTP_UNAUTHORIZED, 'Unauthorized');
        }

        return response()->json([
            'accessToken' => Auth::user()->createToken('Token')->plainTextToken
        ]);
    }

    public function userProfile(): JsonResponse
    {
        return response()->json([
            'email' => Auth::user()->email,
        ]);
    }
}
