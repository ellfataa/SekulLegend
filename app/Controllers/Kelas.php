<?php

namespace App\Controllers;

use App\Models\KelasModel;
use App\Models\MateriModel;
use App\Models\DiskusiModel;
use App\Models\UserModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Kelas extends BaseController
{
    private string $materiUploadPath = FCPATH . 'uploads/materi';

    private function ensureGuru()
    {
        if (! session()->get('logged_in') || session()->get('role') !== 'guru') {
            return redirect()
                ->to('/login')
                ->with('error', 'Silakan login sebagai guru terlebih dahulu.');
        }

        return null;
    }

    private function getOwnedKelas(int $idKelas): ?array
    {
        $kelasModel = new KelasModel();

        return $kelasModel
            ->where('id', $idKelas)
            ->where('id_guru', session()->get('id'))
            ->first();
    }

    private function generateKodeKelas(): string
    {
        $kelasModel = new KelasModel();

        do {
            $kode = strtoupper(bin2hex(random_bytes(3)));
            $exists = $kelasModel->where('kode_kelas', $kode)->first();
        } while ($exists);

        return $kode;
    }

    private function ensureUploadDirectory(): void
    {
        if (! is_dir($this->materiUploadPath)) {
            mkdir($this->materiUploadPath, 0775, true);
        }
    }

    public function index()
    {
        if ($redirect = $this->ensureGuru()) {
            return $redirect;
        }

        $kelasModel = new KelasModel();

        $kelas = $kelasModel
            ->where('id_guru', session()->get('id'))
            ->orderBy('id', 'DESC')
            ->findAll();

        return view('kelas/index', [
            'role'  => session()->get('role'),
            'kelas' => $kelas,
        ]);
    }

    public function tambah()
    {
        if ($redirect = $this->ensureGuru()) {
            return $redirect;
        }

        return view('kelas/tambah');
    }

    public function simpan()
    {
        if ($redirect = $this->ensureGuru()) {
            return $redirect;
        }

        $rules = [
            'nama_kelas' => [
                'label' => 'Nama Kelas',
                'rules' => 'required|min_length[3]|max_length[100]',
            ],
        ];

        if (! $this->validate($rules)) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', implode('<br>', $this->validator->getErrors()));
        }

        $kelasModel = new KelasModel();

        $kelasModel->insert([
            'nama_kelas' => trim((string) $this->request->getPost('nama_kelas')),
            'kode_kelas' => $this->generateKodeKelas(),
            'id_guru'    => session()->get('id'),
        ]);

        return redirect()
            ->to('/kelas')
            ->with('success', 'Kelas berhasil dibuat.');
    }

    public function edit($idKelas)
    {
        if ($redirect = $this->ensureGuru()) {
            return $redirect;
        }

        $kelas = $this->getOwnedKelas((int) $idKelas);

        if (! $kelas) {
            return redirect()
                ->to('/kelas')
                ->with('error', 'Kelas tidak ditemukan atau Anda tidak memiliki akses.');
        }

        return view('kelas/edit', [
            'kelas' => $kelas,
        ]);
    }

    public function update($idKelas)
    {
        if ($redirect = $this->ensureGuru()) {
            return $redirect;
        }

        $kelas = $this->getOwnedKelas((int) $idKelas);

        if (! $kelas) {
            return redirect()
                ->to('/kelas')
                ->with('error', 'Kelas tidak ditemukan atau Anda tidak memiliki akses.');
        }

        $rules = [
            'nama_kelas' => [
                'label' => 'Nama Kelas',
                'rules' => 'required|min_length[3]|max_length[100]',
            ],
        ];

        if (! $this->validate($rules)) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', implode('<br>', $this->validator->getErrors()));
        }

        $kelasModel = new KelasModel();

        $kelasModel->update($idKelas, [
            'nama_kelas' => trim((string) $this->request->getPost('nama_kelas')),
        ]);

        return redirect()
            ->to('/kelas')
            ->with('success', 'Kelas berhasil diperbarui.');
    }

    public function hapus($idKelas)
    {
        if ($redirect = $this->ensureGuru()) {
            return $redirect;
        }

        $kelas = $this->getOwnedKelas((int) $idKelas);

        if (! $kelas) {
            return redirect()
                ->to('/kelas')
                ->with('error', 'Kelas tidak ditemukan atau Anda tidak memiliki akses.');
        }

        $kelasModel = new KelasModel();
        $materiModel = new MateriModel();

        $materiList = $materiModel
            ->where('id_kelas', $idKelas)
            ->findAll();

        foreach ($materiList as $materi) {
            if (! empty($materi['file'])) {
                $filePath = $this->materiUploadPath . '/' . $materi['file'];

                if (is_file($filePath)) {
                    unlink($filePath);
                }
            }
        }

        $materiModel->where('id_kelas', $idKelas)->delete();
        $kelasModel->delete($idKelas);

        return redirect()
            ->to('/kelas')
            ->with('success', 'Kelas berhasil dihapus.');
    }

    public function tambahMateri($idKelas)
    {
        if ($redirect = $this->ensureGuru()) {
            return $redirect;
        }

        $kelas = $this->getOwnedKelas((int) $idKelas);

        if (! $kelas) {
            return redirect()
                ->to('/kelas')
                ->with('error', 'Kelas tidak ditemukan atau Anda tidak memiliki akses.');
        }

        return view('materi/tambah', [
            'id_kelas' => $idKelas,
            'kelas'    => $kelas,
        ]);
    }

    public function simpanMateri()
    {
        if ($redirect = $this->ensureGuru()) {
            return $redirect;
        }

        $idKelas = (int) $this->request->getPost('id_kelas');
        $kelas = $this->getOwnedKelas($idKelas);

        if (! $kelas) {
            return redirect()
                ->to('/kelas')
                ->with('error', 'Kelas tidak ditemukan atau Anda tidak memiliki akses.');
        }

        $rules = [
            'id_kelas' => [
                'label' => 'Kelas',
                'rules' => 'required|is_natural_no_zero',
            ],
            'judul' => [
                'label' => 'Judul Materi',
                'rules' => 'required|min_length[3]|max_length[150]',
            ],
            'deskripsi' => [
                'label' => 'Deskripsi Materi',
                'rules' => 'permit_empty|max_length[1000]',
            ],
            'file' => [
                'label' => 'File Materi',
                'rules' => 'permit_empty|max_size[file,10240]|ext_in[file,pdf,doc,docx,ppt,pptx,xls,xlsx]',
            ],
        ];

        if (! $this->validate($rules)) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', implode('<br>', $this->validator->getErrors()));
        }

        $this->ensureUploadDirectory();

        $file = $this->request->getFile('file');
        $fileName = null;

        if ($file && $file->isValid() && ! $file->hasMoved()) {
            $fileName = $file->getRandomName();
            $file->move($this->materiUploadPath, $fileName);
        }

        $materiModel = new MateriModel();

        $materiModel->insert([
            'id_kelas'  => $idKelas,
            'judul'     => trim((string) $this->request->getPost('judul')),
            'deskripsi' => trim((string) $this->request->getPost('deskripsi')),
            'file'      => $fileName,
        ]);

        return redirect()
            ->to('/materi/kelas/' . $idKelas)
            ->with('success', 'Materi berhasil ditambahkan.');
    }

    public function diskusi($idKelas)
    {
        if ($redirect = $this->ensureGuru()) {
            return $redirect;
        }

        $kelas = $this->getOwnedKelas((int) $idKelas);

        if (! $kelas) {
            throw PageNotFoundException::forPageNotFound('Kelas tidak ditemukan.');
        }

        $diskusiModel = new DiskusiModel();
        $userModel = new UserModel();

        $diskusi = $diskusiModel
            ->where('id_kelas', $idKelas)
            ->orderBy('created_at', 'DESC')
            ->findAll();

        $userMap = [];

        foreach ($diskusi as $d) {
            if (! isset($userMap[$d['id_user']])) {
                $user = $userModel
                    ->select('id, nama')
                    ->find($d['id_user']);

                $userMap[$d['id_user']] = $user['nama'] ?? 'Pengguna';
            }
        }

        return view('kelas/diskusi', [
            'kelas'    => $kelas,
            'diskusi'  => $diskusi,
            'userMap'  => $userMap,
            'id_kelas' => $idKelas,
        ]);
    }

    public function kirimDiskusi($idKelas)
    {
        if ($redirect = $this->ensureGuru()) {
            return $redirect;
        }

        $kelas = $this->getOwnedKelas((int) $idKelas);

        if (! $kelas) {
            return redirect()
                ->to('/kelas')
                ->with('error', 'Kelas tidak ditemukan atau Anda tidak memiliki akses.');
        }

        $rules = [
            'pesan' => [
                'label' => 'Pesan',
                'rules' => 'required|min_length[2]',
            ],
        ];

        if (! $this->validate($rules)) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Pesan diskusi tidak boleh kosong.');
        }

        $diskusiModel = new DiskusiModel();

        $diskusiModel->insert([
            'id_kelas'   => $idKelas,
            'id_user'    => session()->get('id'),
            'pesan'      => trim((string) $this->request->getPost('pesan')),
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        return redirect()
            ->to('/kelas/diskusi/' . $idKelas)
            ->with('success', 'Pesan berhasil dikirim.');
    }

    public function editDiskusi($idDiskusi)
    {
        if ($redirect = $this->ensureGuru()) {
            return $redirect;
        }

        $diskusiModel = new DiskusiModel();
        $komentar = $diskusiModel->find($idDiskusi);

        if (! $komentar || (int) $komentar['id_user'] !== (int) session()->get('id')) {
            return redirect()
                ->back()
                ->with('error', 'Tidak diizinkan.');
        }

        return view('kelas/edit_diskusi', [
            'komentar' => $komentar,
        ]);
    }

    public function updateDiskusi($idDiskusi)
    {
        if ($redirect = $this->ensureGuru()) {
            return $redirect;
        }

        $diskusiModel = new DiskusiModel();
        $komentar = $diskusiModel->find($idDiskusi);

        if (! $komentar || (int) $komentar['id_user'] !== (int) session()->get('id')) {
            return redirect()
                ->back()
                ->with('error', 'Tidak diizinkan.');
        }

        $rules = [
            'pesan' => [
                'label' => 'Pesan',
                'rules' => 'required|min_length[2]',
            ],
        ];

        if (! $this->validate($rules)) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Pesan diskusi tidak boleh kosong.');
        }

        $diskusiModel->update($idDiskusi, [
            'pesan' => trim((string) $this->request->getPost('pesan')),
        ]);

        return redirect()
            ->to('/kelas/diskusi/' . $komentar['id_kelas'])
            ->with('success', 'Komentar berhasil diperbarui.');
    }

    public function hapusDiskusi($idDiskusi, $idKelas)
    {
        if ($redirect = $this->ensureGuru()) {
            return $redirect;
        }

        $diskusiModel = new DiskusiModel();
        $komentar = $diskusiModel->find($idDiskusi);

        if (! $komentar || (int) $komentar['id_user'] !== (int) session()->get('id')) {
            return redirect()
                ->to('/kelas/diskusi/' . $idKelas)
                ->with('error', 'Tidak diizinkan.');
        }

        $diskusiModel->delete($idDiskusi);

        return redirect()
            ->to('/kelas/diskusi/' . $idKelas)
            ->with('success', 'Komentar berhasil dihapus.');
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

        return view('kelas/edit_profil', [
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
            ->to('/kelas')
            ->with('success', 'Profil berhasil diperbarui.');
    }
}