<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogoutController extends Controller
{
    public function logout(Request $request)
    {
        // Ambil token dari request (header atau input)
        $token = $request->header('Authorization') ?? $request->input('token');

        // Jika token tidak ditemukan, kembalikan response error
        if (!$token) {
            return response()->json([
                'success' => false,
                'message' => 'Token tidak ditemukan'
            ], 400);
        }

        // Logout pengguna dengan menghapus sesi autentikasi
        Auth::guard('api')->logout();

        return response()->json([
            'success' => true,
            'message' => 'Logout berhasil'
        ], 200);
    }
}
