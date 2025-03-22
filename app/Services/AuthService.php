<?php

namespace App\Services;

use App\Http\Resources\PassengerResource;
use App\Http\Resources\UserResource;
use App\Models\Passenger;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    /**
     * Register a new user
     *
     * @param array $data
     * @return User
     */
    public function register(array $data)
    {
        $user = new User();
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->password = Hash::make($data['password']);
        $user->save();

        $token = $user->createToken('auth_token')->plainTextToken;

        $passenger = new Passenger();
        $passenger->name = $data['name'];
        $passenger->phone_number = $data['phone_number'];
        $passenger->user_id = $user->id;
        $passenger->save;

        return [
            'token' => $token,
            'user' => new PassengerResource($passenger),
            'redirect_url' => '/dashboard',
        ];
    }

    /**
     * Login user and generate token
     *
     * @param array $data
     * @return array
     * @throws ValidationException
     */
    public function login(array $credentials)
    {

        if (!Auth::attempt($credentials)) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 401);
        }
        $user = User::where('email', $credentials['email'])->first();

        $token = $user->createToken('auth_token')->plainTextToken;

        return [
            'token' => $token,
            'user' => new UserResource($user),
            'redirect_url' => $user->role === 'admin' ? 'admin/dashboard' : '/dashboard',

        ];
    }

    /**
     * Logout user and revoke tokens
     *
     * @param User $user
     * @return void
     */
    public function logout(User $user)
    {
        $user->tokens()->delete();
    }
}
