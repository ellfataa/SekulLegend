<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\KelasModel;

class Guru extends BaseController
{
    private function ensureGuru()
    {
        if (! session()->get('logged_in') || session()->get('role') !== 'guru') {
            return redirect()
                ->to('/login')
                ->with('error', 'Silakan login sebagai guru terlebih dahulu.');
        }

        return null;
    }

    public function dashboard()
    {
        if ($redirect = $this->ensureGuru()) {
            return $redirect;
        }

        return redirect()->to('/guru/kelas');
    }

    public function kelas()
    {
        if ($redirect = $this->ensureGuru()) {
            return $redirect;
        }

        $kelasModel = new KelasModel();

        $kelas = $kelasModel
            ->where('id_guru', session()->get('id'))
            ->orderBy('id', 'DESC')
            ->findAll();

        return view('guru/kelas/index', [
            'kelas' => $kelas,
        ]);
    }

    public function simpanKelas()
    {
        if ($redirect = $this->ensureGuru()) {
            return $redirect;
        }

        $rules = [
            'nama_kelas' => [
                'label' => 'Nama Kelas',
                'rules' => 'required|min_length[3]|max_length[100]',
            ],
            'deskripsi' => [
                'label' => 'Deskripsi',
                'rules' => 'permit_empty|max_length[255]',
            ],
            'materi' => [
                'label' => 'Materi',
                'rules' => 'permit_empty|max_size[materi,2048]|ext_in[materi,pdf,doc,docx,ppt,pptx]',
            ],
        ];

        if (! $this->validate($rules)) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', implode('<br>', $this->validator->getErrors()));
        }

        $kelasModel = new KelasModel();

        $file = $this->request->getFile('materi');
        $namaFile = null;

        if ($file && $file->isValid() && ! $file->hasMoved()) {
            $namaFile = $file->getRandomName();
            $file->move(FCPATH . 'uploads/materi', $namaFile);
        }

        $kelasModel->insert([
            'nama_kelas' => trim((string) $this->request->getPost('nama_kelas')),
            'kode_kelas' => strtoupper(bin2hex(random_bytes(3))),
            'deskripsi'  => trim((string) $this->request->getPost('deskripsi')),
            'materi'     => $namaFile,
            'id_guru'    => session()->get('id'),
        ]);

        return redirect()
            ->to('/guru/kelas')
            ->with('success', 'Kelas berhasil ditambahkan.');
    }

    public function editProfil()
    {
        if ($redirect = $this->ensureGuru()) {
            return $redirect;
        }

        $userModel = new UserModel();
        $idGuru = session()->get('id');

        $guru = $userModel->find($idGuru);

        if (! $guru) {
            return redirect()
                ->to('/login')
                ->with('error', 'Data guru tidak ditemukan.');
        }

        return view('guru/kelas/edit_profil', [
            'guru' => $guru,
        ]);
    }

    public function updateProfil()
    {
        if ($redirect = $this->ensureGuru()) {
            return $redirect;
        }

        $idGuru = session()->get('id');

        $rules = [
            'nama' => [
                'label' => 'Nama Lengkap',
                'rules' => 'required|min_length[3]|max_length[100]',
            ],
            'username' => [
                'label' => 'Username',
                'rules' => "required|min_length[3]|max_length[50]|alpha_numeric_punct|is_unique[users.username,id,{$idGuru}]",
                'errors' => [
                    'is_unique' => 'Username sudah digunakan. Silakan gunakan username lain.',
                ],
            ],
            'password' => [
                'label' => 'Password',
                'rules' => 'permit_empty|min_length[6]',
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
        ];

        $password = (string) $this->request->getPost('password');

        if ($password !== '') {
            $data['password'] = password_hash($password, PASSWORD_DEFAULT);
        }

        $userModel->update($idGuru, $data);

        session()->set([
            'nama' => $data['nama'],
        ]);

        return redirect()
            ->to('/guru/kelas')
            ->with('success', 'Profil berhasil diperbarui.');
    }
}