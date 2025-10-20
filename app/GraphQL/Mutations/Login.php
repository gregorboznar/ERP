<?php declare(strict_types=1);

namespace App\GraphQL\Mutations;

use Exception;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

final readonly class Login
{
    /** @param  array{input: array{email: string, password: string}}  $args */
    public function __invoke(null $_, array $args)
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
}
