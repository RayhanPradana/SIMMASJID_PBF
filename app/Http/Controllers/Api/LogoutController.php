<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class LogoutController extends Controller
{
    public function __invoke(Request $request)
    {
        $removeToken = JWTAuth::invalidate(JWTAuth::getToken());

        if($removeToken){
            return response()->json([
                'success' => true,
                'message' => 'Logout Berhasil',
            ]);
        }
    }
}
