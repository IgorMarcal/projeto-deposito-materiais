<?php

namespace App\Http\Services;

use App\Models\User;
use Carbon\Carbon;
use Hash;
use Illuminate\Http\Request;
use Str;

class CreateUserService 
{
    private string $name;
    private string $email;
    private string $password;

    public function __construct(Request $request) {
        $this->name     = $request->input('name');
        $this->email    = $request->input('email');
        $this->password = $request->input('password');
    }

    public function toCreate(): array{
        
        try{
            
            $searchAccount = User::where('email' , '=', $this->email)->first();
            if($searchAccount){
                throw new \Exception("User already exists!");
            }
            
            // $uuid = Str::uuid();
            $createAccount = User::create([
                // 'id'        => $uuid,
                'name'      => $this->name,
                'email'     => $this->email,
                'password'  => Hash::make($this->password),
            ]);

            $token = $createAccount->createToken('LojaDeMateriais')->plainTextToken;

            return [
                'status'    => true,
                'response'  => [
                    // 'id'    => $uuid,
                    'name'  => $createAccount->name,
                    'token' => "Bearer $token",
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