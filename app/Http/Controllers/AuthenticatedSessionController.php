<?php

namespace App\Http\Controllers;

use App\Models\User;
use Auth;
use Illuminate\Http\Request;

class AuthenticatedSessionController extends Controller
{
    public function me(Request $request) 
    {
        return Auth::user();
    }
}
