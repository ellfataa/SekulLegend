<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\KelasModel;
use App\Models\MateriModel;
use App\Models\DiskusiModel;
use App\Models\SiswaKelasModel;

class Siswa extends BaseController
{
    private function ensureSiswa()
    {
        if (! session()->get('logged_in') || session()->get('role') !== 'siswa') {
            return redirect()
                ->to('/login')
                ->with('error', 'Silakan login sebagai siswa terlebih dahulu.');
        }

        return null;
    }

    public function index()
    {
        if ($redirect = $this->ensureSiswa()) {
            return $redirect;
        }

        $idUser = session()->get('id');

        $siswaKelasModel = new SiswaKelasModel();

        $data = [
            'jumlahKelas' => $siswaKelasModel->countKelasBySiswa($idUser),
        ];

        return view('siswa/dashboard', $data);
    }

    public function kelas()
    {
        if ($redirect = $this->ensureSiswa()) {
            return $redirect;
        }

        $idUser = session()->get('id');

        $siswaKelasModel = new SiswaKelasModel();

        $data = [
            'kelas' => $siswaKelasModel->getKelasBySiswa($idUser),
        ];

        return view('siswa/kelas', $data);
    }

    public function kelasDetail($id)
    {
        if ($redirect = $this->ensureSiswa()) {
            return $redirect;
        }

        $idUser = session()->get('id');

        $siswaKelasModel = new SiswaKelasModel();

        if (! $siswaKelasModel->isSiswaJoined($idUser, $id)) {
            return redirect()
                ->to('/siswa/kelas')
                ->with('error', 'Anda belum bergabung dengan kelas tersebut.');
        }

        $kelasModel   = new KelasModel();
        $materiModel  = new MateriModel();
        $diskusiModel = new DiskusiModel();
        $userModel    = new UserModel();

        $kelas = $kelasModel->find($id);

        if (! $kelas) {
            return redirect()
                ->to('/siswa/kelas')
                ->with('error', 'Kelas tidak ditemukan.');
        }

        $materi = $materiModel
            ->where('id_kelas', $id)
            ->findAll();

        $diskusi = $diskusiModel
            ->where('id_kelas', $id)
            ->orderBy('created_at', 'ASC')
            ->findAll();

        $userMap = [];

        foreach ($userModel->select('id, nama')->findAll() as $user) {
            $userMap[$user['id']] = $user['nama'];
        }

        return view('siswa/kelas_detail', [
            'kelas'   => $kelas,
            'materi'  => $materi,
            'diskusi' => $diskusi,
            'userMap' => $userMap,
        ]);
    }

    public function kirimKomentar($idKelas)
    {
        if ($redirect = $this->ensureSiswa()) {
            return $redirect;
        }

        $rules = [
            'pesan' => [
                'label' => 'Komentar',
                'rules' => 'required|min_length[2]',
            ],
        ];

        if (! $this->validate($rules)) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Komentar tidak boleh kosong.');
        }

        $idUser = session()->get('id');

        $siswaKelasModel = new SiswaKelasModel();

        if (! $siswaKelasModel->isSiswaJoined($idUser, $idKelas)) {
            return redirect()
                ->to('/siswa/kelas')
                ->with('error', 'Anda belum bergabung dengan kelas tersebut.');
        }

        $diskusiModel = new DiskusiModel();

        $diskusiModel->insert([
            'id_user'    => $idUser,
            'id_kelas'   => $idKelas,
            'pesan'      => trim((string) $this->request->getPost('pesan')),
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        return redirect()
            ->to('/siswa/kelas/' . $idKelas)
            ->with('success', 'Komentar berhasil dikirim.');
    }

    public function editDiskusi($id)
    {
        if ($redirect = $this->ensureSiswa()) {
            return $redirect;
        }

        $diskusiModel = new DiskusiModel();
        $komentar = $diskusiModel->find($id);

        if (! $komentar || (int) $komentar['id_user'] !== (int) session()->get('id')) {
            return redirect()
                ->back()
                ->with('error', 'Akses ditolak.');
        }

        return view('siswa/edit_diskusi', [
            'komentar' => $komentar,
        ]);
    }

    public function updateDiskusi($id)
    {
        if ($redirect = $this->ensureSiswa()) {
            return $redirect;
        }

        $rules = [
            'pesan' => [
                'label' => 'Komentar',
                'rules' => 'required|min_length[2]',
            ],
        ];

        if (! $this->validate($rules)) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Komentar tidak boleh kosong.');
        }

        $diskusiModel = new DiskusiModel();
        $komentar = $diskusiModel->find($id);

        if (! $komentar || (int) $komentar['id_user'] !== (int) session()->get('id')) {
            return redirect()
                ->back()
                ->with('error', 'Akses ditolak.');
        }

        $diskusiModel->update($id, [
            'pesan' => trim((string) $this->request->getPost('pesan')),
        ]);

        return redirect()
            ->to('/siswa/kelas/' . $komentar['id_kelas'])
            ->with('success', 'Komentar berhasil diperbarui.');
    }

    public function hapusDiskusi($idKelas, $idDiskusi)
    {
        if ($redirect = $this->ensureSiswa()) {
            return $redirect;
        }

        $diskusiModel = new DiskusiModel();
        $komentar = $diskusiModel->find($idDiskusi);

        if (! $komentar || (int) $komentar['id_user'] !== (int) session()->get('id')) {
            return redirect()
                ->back()
                ->with('error', 'Akses ditolak.');
        }

        $diskusiModel->delete($idDiskusi);

        return redirect()
            ->to('/siswa/kelas/' . $idKelas)
            ->with('success', 'Komentar berhasil dihapus.');
    }

    public function formKodeKelas()
    {
        if ($redirect = $this->ensureSiswa()) {
            return $redirect;
        }

        return view('siswa/form_kode_kelas');
    }

    public function cekKodeKelas()
    {
        if ($redirect = $this->ensureSiswa()) {
            return $redirect;
        }

        $rules = [
            'kode_kelas' => [
                'label' => 'Kode Kelas',
                'rules' => 'required',
            ],
        ];

        if (! $this->validate($rules)) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Kode kelas wajib diisi.');
        }

        $kodeKelas = trim((string) $this->request->getPost('kode_kelas'));
        $idUser = session()->get('id');

        $kelasModel = new KelasModel();
        $siswaKelasModel = new SiswaKelasModel();

        $kelas = $kelasModel
            ->where('kode_kelas', $kodeKelas)
            ->first();

        if (! $kelas) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Kode kelas tidak ditemukan.');
        }

        if ($siswaKelasModel->isSiswaJoined($idUser, $kelas['id'])) {
            return redirect()
                ->to('/siswa/kelas')
                ->with('success', 'Anda sudah bergabung di kelas tersebut.');
        }

        $siswaKelasModel->insert([
            'id_user'  => $idUser,
            'id_kelas' => $kelas['id'],
        ]);

        return redirect()
            ->to('/siswa/kelas')
            ->with('success', 'Berhasil bergabung ke kelas.');
    }

    public function editProfil()
    {
        if ($redirect = $this->ensureSiswa()) {
            return $redirect;
        }

        $userModel = new UserModel();
        $idUser = session()->get('id');

        $siswa = $userModel->find($idUser);

        if (! $siswa) {
            return redirect()
                ->to('/login')
                ->with('error', 'Data pengguna tidak ditemukan.');
        }

        return view('siswa/edit_profil', [
            'siswa' => $siswa,
        ]);
    }

    public function updateProfil()
    {
        if ($redirect = $this->ensureSiswa()) {
            return $redirect;
        }

        $idUser = session()->get('id');

        $rules = [
            'nama' => [
                'label' => 'Nama Lengkap',
                'rules' => 'required|min_length[3]|max_length[100]',
            ],
            'username' => [
                'label' => 'Username',
                'rules' => "required|min_length[3]|max_length[50]|alpha_numeric_punct|is_unique[users.username,id,{$idUser}]",
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

        $userModel->update($idUser, $data);

        session()->set([
            'nama' => $data['nama'],
        ]);

        return redirect()
            ->to('/siswa/dashboard')
            ->with('success', 'Profil berhasil diperbarui.');
    }
}