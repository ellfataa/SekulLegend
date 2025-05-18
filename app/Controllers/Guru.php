<?php

namespace App\Controllers;

class Guru extends BaseController
{
    public function dashboard()
    {
        // Cek apakah sudah login dan role = guru
        if (!session()->get('logged_in') || session()->get('role') != 'guru') {
            return redirect()->to('/login')->with('error', 'Akses ditolak.');
        }

        return view('guru/dashboard', ['kelas' => $kelas]);
    }

    public function kelas()
    {
        $kelasModel = new KelasModel();
        $kelas = $kelasModel->where('id_user', session()->get('id'))->findAll();

        return view('guru/kelas/index', ['kelas' => $kelas]);
    }

    public function simpanKelas()
    {
        $kelasModel = new KelasModel();

        $file = $this->request->getFile('materi');
        $namaFile = null;

        if ($file && $file->isValid()) {
            $namaFile = $file->getRandomName();
            $file->move('public/uploads/materi', $namaFile);
        }

        $kelasModel->insert([
            'nama_kelas' => $this->request->getPost('nama_kelas'),
            'kode_kelas' => strtoupper(bin2hex(random_bytes(3))),
            'deskripsi'  => $this->request->getPost('deskripsi'),
            'materi'     => $namaFile,
            'id_guru'    => session()->get('id')
        ]);

        return redirect()->to('/guru/kelas')->with('success', 'Kelas berhasil ditambahkan');
    }

    // EDIT PROFIL GURU
    public function editProfil()
    {
        $userModel = new \App\Models\UserModel();
        $id = session()->get('id');

        $guru = $userModel->find($id);

        return view('/guru/kelas/edit_profil', ['guru' => $guru]);
    }

    public function updateProfil()
    {
        $userModel = new \App\Models\UserModel();
        $id = session()->get('id');

        $data = [
            'nama'     => $this->request->getPost('nama'),
            'username' => $this->request->getPost('username'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
        ];

        $userModel->update($id, $data);

        return redirect()->to('/guru/kelas/index')->with('success', 'Profil berhasil diperbarui');
    }
}
