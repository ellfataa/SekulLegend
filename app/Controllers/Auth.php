<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    public function login()
    {
        if (session()->get('logged_in')) {
            return $this->redirectByRole(session()->get('role'));
        }

        return view('auth/login');
    }

    public function loginProcess()
    {
        $rules = [
            'username' => [
                'label' => 'Username',
                'rules' => 'required|min_length[3]',
            ],
            'password' => [
                'label' => 'Password',
                'rules' => 'required|min_length[6]',
            ],
        ];

        if (! $this->validate($rules)) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Username dan password wajib diisi dengan benar.');
        }

        $username = trim((string) $this->request->getPost('username'));
        $password = (string) $this->request->getPost('password');

        $userModel = new UserModel();

        $user = $userModel
            ->where('username', $username)
            ->first();

        if (! $user || ! password_verify($password, $user['password'])) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Login gagal! Username atau password salah.');
        }

        session()->regenerate();

        session()->set([
            'id'        => $user['id'],
            'nama'      => $user['nama'],
            'role'      => $user['role'],
            'logged_in' => true,
        ]);

        return $this->redirectByRole($user['role']);
    }

    public function register()
    {
        if (session()->get('logged_in')) {
            return $this->redirectByRole(session()->get('role'));
        }

        return view('auth/register');
    }

    public function registerProcess()
    {
        $rules = [
            'nama' => [
                'label' => 'Nama Lengkap',
                'rules' => 'required|min_length[3]|max_length[100]',
            ],
            'username' => [
                'label' => 'Username',
                'rules' => 'required|min_length[3]|max_length[50]|alpha_numeric_punct|is_unique[users.username]',
                'errors' => [
                    'is_unique' => 'Username sudah digunakan. Silakan gunakan username lain.',
                ],
            ],
            'password' => [
                'label' => 'Password',
                'rules' => 'required|min_length[6]',
            ],
        ];

        if (! $this->validate($rules)) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', implode('<br>', $this->validator->getErrors()));
        }

        $userModel = new UserModel();

        $data = [
            'nama'     => trim((string) $this->request->getPost('nama')),
            'username' => trim((string) $this->request->getPost('username')),
            'password' => password_hash((string) $this->request->getPost('password'), PASSWORD_DEFAULT),
            'role'     => 'siswa',
        ];

        if (! $userModel->insert($data)) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Registrasi gagal. Silakan coba lagi.');
        }

        return redirect()
            ->to('/login')
            ->with('success', 'Registrasi berhasil! Silakan login.');
    }

    public function logout()
    {
        session()->destroy();

        return redirect()
            ->to('/login')
            ->with('success', 'Anda berhasil logout.');
    }

    private function redirectByRole(?string $role)
    {
        return match ($role) {
            'admin' => redirect()->to('/admin/dashboard'),
            'guru'  => redirect()->to('/kelas'),
            'siswa' => redirect()->to('/siswa/dashboard'),
            default => redirect()->to('/login')->with('error', 'Role pengguna tidak dikenali.'),
        };
    }
}