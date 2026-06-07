<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\KelasModel;
use App\Models\MateriModel;
use App\Models\DiskusiModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Admin extends BaseController
{
    protected UserModel $userModel;
    protected KelasModel $kelasModel;
    protected MateriModel $materiModel;
    protected DiskusiModel $diskusiModel;

    private string $materiUploadPath = FCPATH . 'uploads/materi';

    public function __construct()
    {
        $this->userModel    = new UserModel();
        $this->kelasModel   = new KelasModel();
        $this->materiModel  = new MateriModel();
        $this->diskusiModel = new DiskusiModel();
    }

    private function ensureAdmin()
    {
        if (! session()->get('logged_in') || session()->get('role') !== 'admin') {
            return redirect()
                ->to('/login')
                ->with('error', 'Silakan login sebagai admin terlebih dahulu.');
        }

        return null;
    }

    private function ensureUploadDirectory(): void
    {
        if (! is_dir($this->materiUploadPath)) {
            mkdir($this->materiUploadPath, 0775, true);
        }
    }

    private function deleteMateriFile(?string $fileName): void
    {
        if (! $fileName) {
            return;
        }

        $filePath = $this->materiUploadPath . '/' . $fileName;

        if (is_file($filePath)) {
            unlink($filePath);
        }
    }

    private function generateKodeKelas(): string
    {
        do {
            $kode = strtoupper(bin2hex(random_bytes(3)));
            $exists = $this->kelasModel->where('kode_kelas', $kode)->first();
        } while ($exists);

        return $kode;
    }

    public function index()
    {
        return redirect()->to('/admin/dashboard');
    }

    public function dashboard()
    {
        if ($redirect = $this->ensureAdmin()) {
            return $redirect;
        }

        $data = [
            'total_siswa'   => $this->userModel->where('role', 'siswa')->countAllResults(),
            'total_guru'    => $this->userModel->where('role', 'guru')->countAllResults(),
            'total_kelas'   => $this->kelasModel->countAllResults(),
            'total_materi'  => $this->materiModel->countAllResults(),
            'total_diskusi' => $this->diskusiModel->countAllResults(),
        ];

        return view('admin/dashboard', $data);
    }

    // =========================
    // CRUD USER
    // =========================

    public function manajemenUser()
    {
        if ($redirect = $this->ensureAdmin()) {
            return $redirect;
        }

        $data = [
            'users' => $this->userModel
                ->whereIn('role', ['guru', 'siswa'])
                ->orderBy('id', 'DESC')
                ->findAll(),
        ];

        return view('admin/user/index', $data);
    }

    public function tambahUser()
    {
        if ($redirect = $this->ensureAdmin()) {
            return $redirect;
        }

        return view('admin/user/tambah');
    }

    public function simpanUser()
    {
        if ($redirect = $this->ensureAdmin()) {
            return $redirect;
        }

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
            'role' => [
                'label' => 'Role',
                'rules' => 'required|in_list[guru,siswa]',
            ],
        ];

        if (! $this->validate($rules)) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', implode('<br>', $this->validator->getErrors()));
        }

        $this->userModel->insert([
            'nama'     => trim((string) $this->request->getPost('nama')),
            'username' => trim((string) $this->request->getPost('username')),
            'password' => password_hash((string) $this->request->getPost('password'), PASSWORD_DEFAULT),
            'role'     => $this->request->getPost('role'),
        ]);

        return redirect()
            ->to('/admin/user')
            ->with('success', 'User berhasil ditambahkan.');
    }

    public function editUser($id)
    {
        if ($redirect = $this->ensureAdmin()) {
            return $redirect;
        }

        $user = $this->userModel->find($id);

        if (! $user || ! in_array($user['role'], ['guru', 'siswa'], true)) {
            return redirect()
                ->to('/admin/user')
                ->with('error', 'User tidak ditemukan atau tidak dapat diedit.');
        }

        return view('admin/user/edit', [
            'user' => $user,
        ]);
    }

    public function updateUser($id)
    {
        if ($redirect = $this->ensureAdmin()) {
            return $redirect;
        }

        $user = $this->userModel->find($id);

        if (! $user || ! in_array($user['role'], ['guru', 'siswa'], true)) {
            return redirect()
                ->to('/admin/user')
                ->with('error', 'User tidak ditemukan atau tidak dapat diperbarui.');
        }

        $rules = [
            'nama' => [
                'label' => 'Nama Lengkap',
                'rules' => 'required|min_length[3]|max_length[100]',
            ],
            'username' => [
                'label' => 'Username',
                'rules' => "required|min_length[3]|max_length[50]|alpha_numeric_punct|is_unique[users.username,id,{$id}]",
                'errors' => [
                    'is_unique' => 'Username sudah digunakan. Silakan gunakan username lain.',
                ],
            ],
            'password' => [
                'label' => 'Password',
                'rules' => 'permit_empty|min_length[6]',
            ],
            'role' => [
                'label' => 'Role',
                'rules' => 'required|in_list[guru,siswa]',
            ],
        ];

        if (! $this->validate($rules)) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', implode('<br>', $this->validator->getErrors()));
        }

        $data = [
            'nama'     => trim((string) $this->request->getPost('nama')),
            'username' => trim((string) $this->request->getPost('username')),
            'role'     => $this->request->getPost('role'),
        ];

        $password = (string) $this->request->getPost('password');

        if ($password !== '') {
            $data['password'] = password_hash($password, PASSWORD_DEFAULT);
        }

        $this->userModel->update($id, $data);

        return redirect()
            ->to('/admin/user')
            ->with('success', 'User berhasil diperbarui.');
    }

    public function hapusUser($id)
    {
        if ($redirect = $this->ensureAdmin()) {
            return $redirect;
        }

        $user = $this->userModel->find($id);

        if (! $user || ! in_array($user['role'], ['guru', 'siswa'], true)) {
            return redirect()
                ->to('/admin/user')
                ->with('error', 'User tidak ditemukan atau tidak dapat dihapus.');
        }

        $this->userModel->delete($id);

        return redirect()
            ->to('/admin/user')
            ->with('success', 'User berhasil dihapus.');
    }

    // =========================
    // CRUD KELAS
    // =========================

    public function kelas()
    {
        if ($redirect = $this->ensureAdmin()) {
            return $redirect;
        }

        $kelas = $this->kelasModel
            ->select('kelas.*, users.nama as nama_guru')
            ->join('users', 'users.id = kelas.id_guru', 'left')
            ->orderBy('kelas.id', 'DESC')
            ->findAll();

        return view('admin/kelas/index', [
            'kelas' => $kelas,
        ]);
    }

    public function tambahKelas()
    {
        if ($redirect = $this->ensureAdmin()) {
            return $redirect;
        }

        $data = [
            'guru' => $this->userModel
                ->where('role', 'guru')
                ->orderBy('nama', 'ASC')
                ->findAll(),
        ];

        return view('admin/kelas/tambah', $data);
    }

    public function simpanKelas()
    {
        if ($redirect = $this->ensureAdmin()) {
            return $redirect;
        }

        $rules = [
            'nama_kelas' => [
                'label' => 'Nama Kelas',
                'rules' => 'required|min_length[3]|max_length[100]',
            ],
            'id_guru' => [
                'label' => 'Guru',
                'rules' => 'required|is_natural_no_zero',
            ],
            'kode_kelas' => [
                'label' => 'Kode Kelas',
                'rules' => 'permit_empty|max_length[20]|is_unique[kelas.kode_kelas]',
                'errors' => [
                    'is_unique' => 'Kode kelas sudah digunakan.',
                ],
            ],
        ];

        if (! $this->validate($rules)) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', implode('<br>', $this->validator->getErrors()));
        }

        $idGuru = (int) $this->request->getPost('id_guru');
        $guru = $this->userModel
            ->where('id', $idGuru)
            ->where('role', 'guru')
            ->first();

        if (! $guru) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Guru tidak valid.');
        }

        $kodeKelas = trim((string) $this->request->getPost('kode_kelas'));

        $this->kelasModel->insert([
            'nama_kelas' => trim((string) $this->request->getPost('nama_kelas')),
            'kode_kelas' => $kodeKelas !== '' ? strtoupper($kodeKelas) : $this->generateKodeKelas(),
            'id_guru'    => $idGuru,
        ]);

        return redirect()
            ->to('/admin/kelas')
            ->with('success', 'Kelas berhasil ditambahkan.');
    }

    public function editKelas($id)
    {
        if ($redirect = $this->ensureAdmin()) {
            return $redirect;
        }

        $kelas = $this->kelasModel->find($id);

        if (! $kelas) {
            return redirect()
                ->to('/admin/kelas')
                ->with('error', 'Kelas tidak ditemukan.');
        }

        return view('admin/kelas/edit', [
            'kelas' => $kelas,
            'guru'  => $this->userModel->where('role', 'guru')->orderBy('nama', 'ASC')->findAll(),
        ]);
    }

    public function updateKelas($id)
    {
        if ($redirect = $this->ensureAdmin()) {
            return $redirect;
        }

        $kelas = $this->kelasModel->find($id);

        if (! $kelas) {
            return redirect()
                ->to('/admin/kelas')
                ->with('error', 'Kelas tidak ditemukan.');
        }

        $rules = [
            'nama_kelas' => [
                'label' => 'Nama Kelas',
                'rules' => 'required|min_length[3]|max_length[100]',
            ],
            'kode_kelas' => [
                'label' => 'Kode Kelas',
                'rules' => "required|max_length[20]|is_unique[kelas.kode_kelas,id,{$id}]",
                'errors' => [
                    'is_unique' => 'Kode kelas sudah digunakan.',
                ],
            ],
        ];

        if (! $this->validate($rules)) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', implode('<br>', $this->validator->getErrors()));
        }

        $this->kelasModel->update($id, [
            'nama_kelas' => trim((string) $this->request->getPost('nama_kelas')),
            'kode_kelas' => strtoupper(trim((string) $this->request->getPost('kode_kelas'))),
        ]);

        return redirect()
            ->to('/admin/kelas')
            ->with('success', 'Kelas berhasil diperbarui.');
    }

    public function hapusKelas($id)
    {
        if ($redirect = $this->ensureAdmin()) {
            return $redirect;
        }

        $kelas = $this->kelasModel->find($id);

        if (! $kelas) {
            return redirect()
                ->to('/admin/kelas')
                ->with('error', 'Kelas tidak ditemukan.');
        }

        $materiList = $this->materiModel
            ->where('id_kelas', $id)
            ->findAll();

        foreach ($materiList as $materi) {
            $this->deleteMateriFile($materi['file'] ?? null);
        }

        $this->materiModel->where('id_kelas', $id)->delete();
        $this->diskusiModel->where('id_kelas', $id)->delete();
        $this->kelasModel->delete($id);

        return redirect()
            ->to('/admin/kelas')
            ->with('success', 'Kelas berhasil dihapus.');
    }

    // =========================
    // CRUD MATERI
    // =========================

    public function materi()
    {
        if ($redirect = $this->ensureAdmin()) {
            return $redirect;
        }

        $materi = $this->materiModel
            ->select('materi.*, kelas.nama_kelas')
            ->join('kelas', 'kelas.id = materi.id_kelas', 'left')
            ->orderBy('materi.id', 'DESC')
            ->findAll();

        return view('admin/materi/index', [
            'materi' => $materi,
        ]);
    }

    public function tambahMateri()
    {
        if ($redirect = $this->ensureAdmin()) {
            return $redirect;
        }

        return view('admin/materi/tambah', [
            'kelas' => $this->kelasModel->orderBy('nama_kelas', 'ASC')->findAll(),
        ]);
    }

    public function simpanMateri()
    {
        if ($redirect = $this->ensureAdmin()) {
            return $redirect;
        }

        $rules = [
            'judul' => [
                'label' => 'Judul Materi',
                'rules' => 'required|min_length[3]|max_length[150]',
            ],
            'deskripsi' => [
                'label' => 'Deskripsi Materi',
                'rules' => 'permit_empty|max_length[1000]',
            ],
            'id_kelas' => [
                'label' => 'Kelas',
                'rules' => 'required|is_natural_no_zero',
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

        $idKelas = (int) $this->request->getPost('id_kelas');

        if (! $this->kelasModel->find($idKelas)) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Kelas tidak ditemukan.');
        }

        $this->ensureUploadDirectory();

        $file = $this->request->getFile('file');
        $fileName = null;

        if ($file && $file->isValid() && ! $file->hasMoved()) {
            $fileName = $file->getRandomName();
            $file->move($this->materiUploadPath, $fileName);
        }

        $this->materiModel->insert([
            'judul'     => trim((string) $this->request->getPost('judul')),
            'deskripsi' => trim((string) $this->request->getPost('deskripsi')),
            'file'      => $fileName,
            'id_kelas'  => $idKelas,
        ]);

        return redirect()
            ->to('/admin/materi')
            ->with('success', 'Materi berhasil ditambahkan.');
    }

    public function editMateri($id)
    {
        if ($redirect = $this->ensureAdmin()) {
            return $redirect;
        }

        $materi = $this->materiModel->find($id);

        if (! $materi) {
            return redirect()
                ->to('/admin/materi')
                ->with('error', 'Materi tidak ditemukan.');
        }

        return view('admin/materi/edit', [
            'materi' => $materi,
            'kelas'  => $this->kelasModel->orderBy('nama_kelas', 'ASC')->findAll(),
        ]);
    }

    public function updateMateri($id)
    {
        if ($redirect = $this->ensureAdmin()) {
            return $redirect;
        }

        $materi = $this->materiModel->find($id);

        if (! $materi) {
            return redirect()
                ->to('/admin/materi')
                ->with('error', 'Materi tidak ditemukan.');
        }

        $rules = [
            'judul' => [
                'label' => 'Judul Materi',
                'rules' => 'required|min_length[3]|max_length[150]',
            ],
            'deskripsi' => [
                'label' => 'Deskripsi Materi',
                'rules' => 'permit_empty|max_length[1000]',
            ],
            'id_kelas' => [
                'label' => 'Kelas',
                'rules' => 'required|is_natural_no_zero',
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

        $data = [
            'judul'     => trim((string) $this->request->getPost('judul')),
            'deskripsi' => trim((string) $this->request->getPost('deskripsi')),
            'id_kelas'  => (int) $this->request->getPost('id_kelas'),
        ];

        $file = $this->request->getFile('file');

        if ($file && $file->isValid() && ! $file->hasMoved()) {
            $this->ensureUploadDirectory();

            $newName = $file->getRandomName();
            $file->move($this->materiUploadPath, $newName);

            $this->deleteMateriFile($materi['file'] ?? null);

            $data['file'] = $newName;
        }

        $this->materiModel->update($id, $data);

        return redirect()
            ->to('/admin/materi')
            ->with('success', 'Materi berhasil diperbarui.');
    }

    public function hapusMateri($id)
    {
        if ($redirect = $this->ensureAdmin()) {
            return $redirect;
        }

        $materi = $this->materiModel->find($id);

        if (! $materi) {
            return redirect()
                ->to('/admin/materi')
                ->with('error', 'Materi tidak ditemukan.');
        }

        $this->deleteMateriFile($materi['file'] ?? null);
        $this->materiModel->delete($id);

        return redirect()
            ->to('/admin/materi')
            ->with('success', 'Materi berhasil dihapus.');
    }

    // =========================
    // DISKUSI
    // =========================

    public function diskusi()
    {
        if ($redirect = $this->ensureAdmin()) {
            return $redirect;
        }

        $kelas = $this->kelasModel
            ->select('kelas.id, kelas.nama_kelas, COUNT(diskusi_kelas.id) as total_diskusi')
            ->join('diskusi_kelas', 'diskusi_kelas.id_kelas = kelas.id', 'left')
            ->groupBy('kelas.id, kelas.nama_kelas')
            ->orderBy('kelas.id', 'DESC')
            ->findAll();

        return view('admin/diskusi/index', [
            'kelas' => $kelas,
        ]);
    }

    public function diskusiKelas($idKelas)
    {
        if ($redirect = $this->ensureAdmin()) {
            return $redirect;
        }

        $kelas = $this->kelasModel->find($idKelas);

        if (! $kelas) {
            throw PageNotFoundException::forPageNotFound('Kelas tidak ditemukan.');
        }

        $komentar = $this->diskusiModel
            ->select('diskusi_kelas.*, users.nama as nama_user')
            ->join('users', 'users.id = diskusi_kelas.id_user', 'left')
            ->where('diskusi_kelas.id_kelas', $idKelas)
            ->orderBy('diskusi_kelas.created_at', 'DESC')
            ->findAll();

        return view('admin/diskusi/kelas', [
            'komentar' => $komentar,
            'kelas'    => $kelas,
        ]);
    }

    public function hapusDiskusi($id)
    {
        if ($redirect = $this->ensureAdmin()) {
            return $redirect;
        }

        $komentar = $this->diskusiModel->find($id);

        if (! $komentar) {
            return redirect()
                ->back()
                ->with('error', 'Komentar tidak ditemukan.');
        }

        $this->diskusiModel->delete($id);

        return redirect()
            ->back()
            ->with('success', 'Komentar berhasil dihapus.');
    }
}