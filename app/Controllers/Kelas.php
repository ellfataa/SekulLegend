<?php

namespace App\Controllers;
use App\Models\KelasModel;
use App\Models\MateriModel;

class Kelas extends BaseController
{
    public function index()
    {
        $role = session()->get('role');
        $id_user = session()->get('id');

        $kelasModel = new KelasModel();

        $kelas = [];
        if ($role === 'guru') {
            $kelas = $kelasModel->where('id_guru', $id_user)->findAll();
        }

        return view('kelas/index', ['role' => $role, 'kelas' => $kelas]);
    }

    public function tambah()
    {
        return view('kelas/tambah');
    }

    public function simpan()
    {
        $kelasModel = new KelasModel();

        $kodeUnik = strtoupper(substr(md5(uniqid()), 0, 6)); // Contoh: A1B2C3

        $kelasModel->insert([
            'nama_kelas' => $this->request->getPost('nama_kelas'),
            'kode_kelas' => $kodeUnik,
            'id_guru' => session()->get('id')
        ]);

        return redirect()->to('/kelas')->with('success', 'Kelas berhasil dibuat!');
    }

    public function edit($id_kelas)
    {
        $kelasModel = new KelasModel();
        $kelas = $kelasModel->find($id_kelas);

        if (!$kelas || $kelas['id_guru'] != session()->get('id')) {
            return redirect()->to('/kelas')->with('error', 'Tidak diizinkan.');
        }

        return view('kelas/edit', ['kelas' => $kelas]);
    }

    public function update($id_kelas)
    {
        $kelasModel = new KelasModel();
        $kelas = $kelasModel->find($id_kelas);

        if (!$kelas || $kelas['id_guru'] != session()->get('id')) {
            return redirect()->to('/kelas')->with('error', 'Tidak diizinkan.');
        }

        $kelasModel->update($id_kelas, [
            'nama_kelas' => $this->request->getPost('nama_kelas'),
        ]);

        return redirect()->to('/kelas')->with('success', 'Kelas berhasil diperbarui!');
    }

    public function hapus($id_kelas)
    {
        $kelasModel = new KelasModel();
        $kelas = $kelasModel->find($id_kelas);

        if (!$kelas || $kelas['id_guru'] != session()->get('id')) {
            return redirect()->to('/kelas')->with('error', 'Tidak diizinkan.');
        }

        $kelasModel->delete($id_kelas);

        return redirect()->to('/kelas')->with('success', 'Kelas berhasil dihapus.');
    }

    // MATERI
    public function tambahMateri($id_kelas)
    {
        return view('materi/tambah', ['id_kelas' => $id_kelas]);
    }

    public function simpanMateri()
    {
        $materiModel = new MateriModel();

        $file = $this->request->getFile('file');
        $fileName = null;

        if ($file && $file->isValid() && !$file->hasMoved()) {
            $fileName = $file->getRandomName();
            $file->move('public/uploads/materi', $fileName);
        }

        $materiModel->save([
            'id_kelas' => $this->request->getPost('id_kelas'),
            'judul' => $this->request->getPost('judul'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'file' => $fileName
        ]);

        return redirect()->to('/kelas')->with('success', 'Materi berhasil ditambahkan.');
    }

    // DISKUSI/KOMENTAR
    public function diskusi($id_kelas)
    {
        $kelasModel = new \App\Models\KelasModel();
        $diskusiModel = new \App\Models\DiskusiModel();
        $userModel   = new \App\Models\UserModel();

        $kelas = $kelasModel->find($id_kelas);
        if (!$kelas) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Kelas tidak ditemukan.");
        }

        $diskusi = $diskusiModel
            ->where('id_kelas', $id_kelas)
            ->orderBy('created_at', 'DESC')
            ->findAll();

        // Ambil user untuk nama pengirim
        $userMap = [];
        foreach ($diskusi as $d) {
            if (!isset($userMap[$d['id_user']])) {
                $user = $userModel->find($d['id_user']);
                $userMap[$d['id_user']] = $user['nama'] ?? 'Pengguna';
            }
        }

        return view('kelas/diskusi', [
            'kelas'   => $kelas,
            'diskusi' => $diskusi,
            'userMap' => $userMap,
            'id_kelas' => $id_kelas
        ]);
    }

    public function kirimDiskusi($id_kelas)
    {
        $diskusiModel = new \App\Models\DiskusiModel();

        $data = [
            'id_kelas' => $id_kelas,
            'id_user'  => session()->get('id'), // Perbaikan di sini
            'pesan'    => $this->request->getPost('pesan'),
            'created_at' => date('Y-m-d H:i:s') // Tambahkan jika pakai created_at manual
        ];

        $diskusiModel->insert($data);
        return redirect()->to('/kelas/diskusi/' . $id_kelas);
    }

    public function editDiskusi($id_diskusi)
    {
        $diskusiModel = new \App\Models\DiskusiModel();
        $komentar = $diskusiModel->find($id_diskusi);

        if (!$komentar || $komentar['id_user'] != session()->get('id')) {
            return redirect()->back()->with('error', 'Tidak diizinkan.');
        }

        return view('kelas/edit_diskusi', ['komentar' => $komentar]);
    }

    public function updateDiskusi($id_diskusi)
    {
        $diskusiModel = new \App\Models\DiskusiModel();
        $komentar = $diskusiModel->find($id_diskusi);

        if (!$komentar || $komentar['id_user'] != session()->get('id')) {
            return redirect()->back()->with('error', 'Tidak diizinkan.');
        }

        $diskusiModel->update($id_diskusi, [
            'pesan' => $this->request->getPost('pesan')
        ]);

        return redirect()->to('/kelas/diskusi/' . $komentar['id_kelas'])->with('success', 'Komentar berhasil diperbarui.');
    }

    public function hapusDiskusi($id_diskusi, $id_kelas)
    {
        $diskusiModel = new \App\Models\DiskusiModel();
        $komentar = $diskusiModel->find($id_diskusi);

        if (!$komentar || $komentar['id_user'] != session()->get('id')) {
            return redirect()->to('/kelas/diskusi/' . $id_kelas)->with('error', 'Tidak diizinkan.');
        }

        $diskusiModel->delete($id_diskusi);

        return redirect()->to('/kelas/diskusi/' . $id_kelas)->with('success', 'Komentar berhasil dihapus.');
    }

    // Edit Profil
    public function editProfil()
    {
        $userModel = new \App\Models\UserModel();
        $id = session()->get('id');

        $guru = $userModel->find($id);

        return view('kelas/edit_profil', ['guru' => $guru]);
    }

    // Update Profil
    public function updateProfil()
    {
        $userModel = new \App\Models\UserModel();
        $id = session()->get('id');

        $data = [
            'nama'     => $this->request->getPost('nama'),
            'username' => $this->request->getPost('username')
        ];

        // Jika password diisi, update juga
        if ($this->request->getPost('password')) {
            $data['password'] = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
        }

        $userModel->update($id, $data);
        return redirect()->to('/kelas')->with('success', 'Profil berhasil diperbarui.');
    }

}
