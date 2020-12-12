<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class TokenController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param Request $request
     * @return Response
     */
    public function login(Request $request): Response
    {
        /** @var User $user */
        $user = User::where('email', $request->input('login'))->first();

        if (!$user) {
            return response([
                'status' => 'FAILED',
                'reason' => 'User not found'
            ]);
        }

        if ($user->role->name === 'Buyer') {
            return response([
                'status' => 'FAILED',
                'reason' => 'Access denied'
            ]);
        }

        if (!Hash::check($request->input('password'), $user->getAuthPassword())) {
            return response([
                'status' => 'FAILED',
                'reason' => 'Invalid password'
            ]);
        }

        return response([
            'status' => 'OK',
            'token' => $user->createToken($request->token_name ?? 'token')->plainTextToken,
        ]);
    }
}
