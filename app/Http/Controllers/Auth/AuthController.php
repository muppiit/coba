<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Master\UserModel;
use App\Traits\TraitsController;

class AuthController extends Controller
{
    use TraitsController;

    public function showLoginForm()
    {
        return view('auth.login', [
            'title' => 'Login'
        ]);
    }

    public function login(Request $request)
    {
        try {
            // Validasi input
            $this->validate($request, [
                'username' => 'required|string',
                'password' => 'required|string',
            ]);

            // Cari user berdasarkan username
            $user = UserModel::where('username', $request->username)
                ->where('isDeleted', 0)
                ->first();

            if (!$user) {
                return $this->redirectError('User tidak ditemukan atau sudah dinonaktifkan.');
            }

            // Verifikasi password
            if (!Hash::check($request->password, $user->password)) {
                return $this->redirectError('Password salah.');
            }

            Auth::login($user);

            return $this->redirectSuccess(route('transaction.surat.index'), 'Selamat datang, ' . $user->nama_lengkap . '!');
        } catch (\Exception $e) {
            return $this->redirectException($e, 'Login');
        }
    }


    public function logout()
    {
        Auth::logout();

        return redirect()->route('login')->with('success', 'Anda telah logout.');
    }
}
