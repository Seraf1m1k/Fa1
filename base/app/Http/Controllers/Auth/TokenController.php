<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Validator;

class TokenController extends Controller
{
    /**
     * Create a new token.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(){
        $upperEmail = Str::random(6);
        $email = $upperEmail.'@gmail.com';
        $user = User::create([
            'name' => 'exemple',
            'email' => $email,
            'password' => Hash::make('password')
        ]);
        $data['token'] = $user->createToken($email)->plainTextToken;
        $data['user'] = $user;

        $response = [
            'status' => 'success',
            'message' => 'Token created successfully',
            'data' => $data,
        ];

        return response()->json($response, 201);
    }
}
