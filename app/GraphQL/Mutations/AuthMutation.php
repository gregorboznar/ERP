<?php

namespace App\GraphQL\Mutations;

use Exception;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

class AuthMutation
{
    public function login($root, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        $credentials = $args['input'];
        
        if (!Auth::attempt($credentials)) {
            throw new Exception('Invalid credentials');
        }

        $user = Auth::user();
        $token = $user->createToken('API Token')->plainTextToken;

        return [
            'access_token' => $token,
            'token_type' => 'Bearer',
            'expires_in' => 3600, // 1 hour
            'user' => $user
        ];
    }

    public function logout($root, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        $context->user()->currentAccessToken()->delete();
        
        return [
            'message' => 'Successfully logged out'
        ];
    }
}