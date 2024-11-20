<?php

namespace App\Http\Services;

use App\Models\User;
use Hash;

class LogginService 
{
    private string $email;
    private string $password;

    public function __construct(array $credentials) {
        $this->email    = $credentials['email'];
        $this->password = $credentials['password'];
    }

    public function toLogin(): array{
        
        try{
            $user = User::where('email', $this->email)->first();
            
            if (!$user || !Hash::check($this->password, $user->password)) {
               throw new \Exception("Invalid credentials");
            }

            $token = $user->createToken('LojaDeMateriais')->plainTextToken;
 
            return [
                'status'    => true,
                'response'  => [
                    'id'    => $user->id,
                    'name'  => $user->name,
                    'token' => "Bearer $token"
                ],
            ];

        }catch (\Exception $e){
            return [
                'status'   => false,
                'response' => $e->getMessage()
            ];
        }
    }
}
