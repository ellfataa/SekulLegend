<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\KelasModel;
use App\Models\MateriModel;
use App\Models\DiskusiModel;
use App\Models\SiswaKelasModel;

class Siswa extends BaseController
{
    public function index()
    {
        $kelasModel = new KelasModel();
        $data['kelas'] = $kelasModel->findAll();
        return view('siswa/dashboard', $data);
    }

    public function kelas()
    {
        $id_user = session()->get('id');
        $db = \Config\Database::connect();
        $builder = $db->table('siswa_kelas');
        $builder->select('kelas.*');
        $builder->join('kelas', 'kelas.id = siswa_kelas.id_kelas');
        $builder->where('siswa_kelas.id_user', $id_user);
        $kelas = $builder->get()->getResultArray();

        return view('siswa/kelas', ['kelas' => $kelas]);
    }

    public function kelasDetail($id)
    {
        $kelasModel = new KelasModel();
        $materiModel = new MateriModel();
        $diskusiModel = new DiskusiModel();
        $userModel = new UserModel();

        $kelas = $kelasModel->find($id);
        $materi = $materiModel->where('id_kelas', $id)->findAll();
        $diskusi = $diskusiModel->where('id_kelas', $id)->orderBy('created_at', 'ASC')->findAll();

        // Buat map id_user => nama
        $userList = $userModel->findAll();
        $userMap = [];
        foreach ($userList as $user) {
            $userMap[$user['id']] = $user['nama'];
        }

        return view('siswa/kelas_detail', [
            'kelas' => $kelas,
            'materi' => $materi,
            'diskusi' => $diskusi,
            'userMap' => $userMap
        ]);
    }

    public function kirimKomentar($id_kelas)
    {
        $diskusiModel = new DiskusiModel();
        $diskusiModel->insert([
            'id_user' => session()->get('id'),
            'id_kelas' => $id_kelas,
            'pesan' => $this->request->getPost('pesan'),
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        return redirect()->to('/siswa/kelas/' . $id_kelas);
    }

    public function editDiskusi($id)
    {
        $diskusiModel = new DiskusiModel();
        $komentar = $diskusiModel->find($id);

        if (!$komentar || $komentar['id_user'] != session()->get('id')) {
            return redirect()->back()->with('error', 'Akses ditolak.');
        }

        return view('siswa/edit_diskusi', ['komentar' => $komentar]);
    }

    public function updateDiskusi($id)
    {
        $diskusiModel = new DiskusiModel();
        $komentar = $diskusiModel->find($id);

        if (!$komentar || $komentar['id_user'] != session()->get('id')) {
            return redirect()->back()->with('error', 'Akses ditolak.');
        }

        $pesan = $this->request->getPost('pesan');
        $diskusiModel->update($id, ['pesan' => $pesan]);

        return redirect()->to('/siswa/kelas/' . $komentar['id_kelas']);
    }


    public function hapusDiskusi($id_kelas, $id_diskusi)
    {
        $diskusiModel = new DiskusiModel();
        $komentar = $diskusiModel->find($id_diskusi);

        if (!$komentar || $komentar['id_user'] != session()->get('id')) {
            return redirect()->back()->with('error', 'Akses ditolak.');
        }

        $diskusiModel->delete($id_diskusi);

        return redirect()->to('/siswa/kelas/' . $id_kelas);
    }

    public function formKodeKelas()
    {
        return view('siswa/form_kode_kelas');
    }

    public function cekKodeKelas()
    {
        $kode = $this->request->getPost('kode_kelas');
        $id_user = session()->get('id');

        $kelasModel = new KelasModel();
        $siswaKelasModel = new SiswaKelasModel();

        $kelas = $kelasModel->where('kode_kelas', $kode)->first();

        if (!$kelas) {
            return redirect()->back()->with('error', 'Kode kelas tidak ditemukan.');
        }

        // Cek apakah siswa sudah bergabung
        $sudah = $siswaKelasModel
            ->where('id_user', $id_user)
            ->where('id_kelas', $kelas['id'])
            ->first();

        if (!$sudah) {
            $siswaKelasModel->insert([
                'id_user' => $id_user,
                'id_kelas' => $kelas['id']
            ]);
        }

        return redirect()->to('/siswa/kelas');
    }

    // EDIT PROFIL
    public function editProfil()
    {
        $userModel = new \App\Models\UserModel();
        $id = session()->get('id');

        $siswa = $userModel->find($id);

        return view('siswa/edit_profil', ['siswa' => $siswa]);
    }

    public function updateProfil()
    {
        $userModel = new \App\Models\UserModel();
        $id = session()->get('id');

        $data = [
            'nama' => $this->request->getPost('nama'),
            'username' => $this->request->getPost('username')
        ];

        // Jika password diisi, update juga
        $password = $this->request->getPost('password');
        if (!empty($password)) {
            $data['password'] = password_hash($password, PASSWORD_DEFAULT);
        }

        $userModel->update($id, $data);

        return redirect()->to('/siswa/dashboard')->with('success', 'Profil berhasil diperbarui!');
    }


}
