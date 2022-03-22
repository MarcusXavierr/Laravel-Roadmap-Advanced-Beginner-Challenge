<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $fields = $request->validate(
            [
                'name' => 'required|string',
                'email' => 'required|string|unique:users,email',
                'password' => 'required|string'
            ]
        );


        $user = User::create(
            [
                'name' => $fields['name'],
                'email' =>  $fields['email'],
                'password' => bcrypt($fields['password'])
            ]
        );

        $token = $user->createToken('mytoken')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
    }
}
