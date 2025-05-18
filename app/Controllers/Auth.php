<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    public function login()
    {
        return view('auth/login');
    }

    public function loginProcess()
    {
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $userModel = new UserModel();
        $user = $userModel->where('username', $username)->first();

        if ($user && password_verify($password, $user['password'])) {
            session()->set([
                'id' => $user['id'],
                'nama' => $user['nama'],
                'role' => $user['role'],
                'logged_in' => true
            ]);

            // Redirect sesuai role
            if ($user['role'] === 'admin') {
                return redirect()->to('/admin/dashboard');
            } elseif ($user['role'] === 'guru') {
                return redirect()->to('/kelas');
            } elseif ($user['role'] === 'siswa') {
                return redirect()->to('/siswa/dashboard');
            }
        }


        return redirect()->back()->with('error', 'Login gagal! Username atau password salah.');
    }

    public function register()
    {
        return view('auth/register');
    }

    public function registerProcess()
    {
        $userModel = new UserModel();

        $data = [
            'nama'     => $this->request->getPost('nama'),
            'username' => $this->request->getPost('username'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'role'     => 'siswa' // Otomatis siswa
        ];

        $userModel->insert($data);
        return redirect()->to('/login')->with('success', 'Registrasi berhasil! Silakan login.');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}
