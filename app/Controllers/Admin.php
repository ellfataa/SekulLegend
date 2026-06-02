<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\KelasModel;
use App\Models\MateriModel;
use App\Models\DiskusiModel;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\Controller;
use CodeIgniter\Database\BaseConnection;

class Admin extends BaseController
{
    protected $userModel;
    protected $kelasModel;
    protected $materiModel;
    protected $diskusiModel;
    protected $db;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->kelasModel = new KelasModel();
        $this->materiModel = new MateriModel();
        $this->diskusiModel = new DiskusiModel();
        $this->db = \Config\Database::connect();
    }

    // Akses utama: /admin
    public function index()
    {
        return $this->dashboard(); // Redirect ke method dashboard
    }

    // Akses langsung ke dashboard: /admin/dashboard
    public function dashboard()
    {
        $data = [
            'total_siswa'   => $this->userModel->where('role', 'siswa')->countAllResults(),
            'total_guru'    => $this->userModel->where('role', 'guru')->countAllResults(),
            'total_kelas'   => $this->kelasModel->countAllResults(),
            'total_materi'  => $this->materiModel->countAllResults(),
            'total_diskusi' => $this->diskusiModel->countAllResults(),
        ];

        return view('admin/dashboard', $data);
    }

    // CRUD USER
    public function manajemenUser()
    {
        $userModel = new UserModel();
        $data['users'] = $userModel->whereIn('role', ['guru', 'siswa'])->findAll();

        return view('admin/user/index', $data);
    }

    public function tambahUser()
    {
        return view('admin/user/tambah');
    }

    public function simpanUser()
    {
        $userModel = new UserModel();

        $data = [
            'nama' => $this->request->getPost('nama'),
            'username' => $this->request->getPost('username'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'role' => $this->request->getPost('role'),
        ];

        $userModel->insert($data);
        return redirect()->to('/admin/user')->with('success', 'User berhasil ditambahkan.');
    }

    public function editUser($id)
    {
        $userModel = new UserModel();
        $data['user'] = $userModel->find($id);
        return view('admin/user/edit', $data);
    }

    public function updateUser($id)
    {
        $userModel = new UserModel();

        $data = [
            'nama' => $this->request->getPost('nama'),
            'username' => $this->request->getPost('username'),
            'role' => $this->request->getPost('role'),
        ];

        if ($this->request->getPost('password')) {
            $data['password'] = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
        }

        $userModel->update($id, $data);
        return redirect()->to('/admin/user')->with('success', 'User berhasil diperbarui.');
    }

    public function hapusUser($id)
    {
        $userModel = new UserModel();
        $userModel->delete($id);
        return redirect()->to('/admin/user')->with('success', 'User berhasil dihapus.');
    }

    // CRUD KELAS
    public function kelas()
    {
        $kelasModel = new KelasModel();
        $data['kelas'] = $kelasModel->findAll();
        return view('admin/kelas/index', $data);
    }

    public function tambahKelas()
    {
        $data['guru'] = $this->userModel->where('role', 'guru')->findAll();
        return view('admin/kelas/tambah', $data);
    }


    public function simpanKelas()
    {
        $kelasModel = new KelasModel();
        $id_guru = $this->request->getPost('id_guru');

        $kelasModel->insert([
            'nama_kelas' => $this->request->getPost('nama_kelas'),
            'kode_kelas' => $this->request->getPost('kode_kelas'),
            'id_guru'    => $id_guru,
        ]);

        return redirect()->to('/admin/kelas')->with('success', 'Kelas berhasil ditambahkan.');
    }

    public function editKelas($id)
    {
        $kelasModel = new KelasModel();
        $data['kelas'] = $kelasModel->find($id);
        return view('admin/kelas/edit', $data);
    }

    public function updateKelas($id)
    {
        $kelasModel = new KelasModel();
        $kelasModel->update($id, [
            'nama_kelas' => $this->request->getPost('nama_kelas'),
            'kode_kelas' => $this->request->getPost('kode_kelas'),
        ]);

        return redirect()->to('/admin/kelas')->with('success', 'Kelas berhasil diperbarui.');
    }

    public function hapusKelas($id)
    {
        $kelasModel = new KelasModel();
        $kelasModel->delete($id);
        return redirect()->to('/admin/kelas')->with('success', 'Kelas berhasil dihapus.');
    }

    // CRUD MATERI
    public function materi()
    {
        $materiModel = new MateriModel();
        $data['materi'] = $materiModel->findAll();
        return view('admin/materi/index', $data);
    }

    public function tambahMateri()
    {
         $kelasModel = new KelasModel();
        $data['kelas'] = $kelasModel->findAll();
        return view('admin/materi/tambah', $data);
    }

    public function simpanMateri()
    {
        $file = $this->request->getFile('file');

        if ($file && $file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move('public/uploads/materi/', $newName);

            $this->materiModel->insert([
                'judul'     => $this->request->getPost('judul'),
                'deskripsi' => $this->request->getPost('deskripsi'),
                'file'      => $newName,
                'id_kelas'  => $this->request->getPost('id_kelas'),
            ]);

            return redirect()->to('/admin/materi')->with('success', 'Materi berhasil ditambahkan.');
        }

        return redirect()->back()->with('error', 'Gagal mengunggah file. Pastikan file valid.');
    }

    public function editMateri($id)
    {
        $materiModel = new MateriModel();
        $data['materi'] = $materiModel->find($id);
        return view('admin/materi/edit', $data);
    }

    public function updateMateri($id)
    {
        $materiModel = new MateriModel();

        $judul = $this->request->getPost('judul');
        $deskripsi = $this->request->getPost('deskripsi');

        $file = $this->request->getFile('file');
        $data = [
            'judul' => $judul,
            'deskripsi' => $deskripsi,
        ];

        if ($file && $file->isValid() && !$file->hasMoved()) {
            // simpan file ke folder uploads
            $newName = $file->getRandomName();
            $file->move('public/uploads/materi/', $newName);
            $data['file'] = $newName;

            // hapus file lama jika ada
            $lama = $materiModel->find($id)['file'];
            if ($lama && file_exists('public/uploads/materi/' . $lama)) {
                unlink('public/uploads/materi/' . $lama);
            }
        }

        $materiModel->update($id, $data);

        return redirect()->to('/admin/materi')->with('success', 'Materi berhasil diperbarui.');
    }


    public function hapusMateri($id)
    {
        $materiModel = new MateriModel();
        $materiModel->delete($id);
        return redirect()->to('/admin/materi')->with('success', 'Materi berhasil dihapus.');
    }

    // CRUD DISKUSI
    public function diskusi()
    {
        $db = \Config\Database::connect();
        $kelas = $db->table('kelas')
            ->select('kelas.id, kelas.nama_kelas, COUNT(diskusi_kelas.id) as total_diskusi')
            ->join('diskusi_kelas', 'diskusi_kelas.id_kelas = kelas.id', 'left')
            ->groupBy('kelas.id')
            ->get()->getResultArray();

        return view('admin/diskusi/index', ['kelas' => $kelas]);
    }

    // Menampilkan komentar diskusi dari satu kelas
    public function diskusiKelas($id_kelas)
    {
        $diskusiModel = new DiskusiModel();

        $komentar = $diskusiModel
            ->select('diskusi_kelas.*, users.nama as nama_user')
            ->join('users', 'users.id = diskusi_kelas.id_user')
            ->where('id_kelas', $id_kelas)
            ->orderBy('created_at', 'DESC')
            ->findAll();

        $kelas = $this->db->table('kelas')->where('id', $id_kelas)->get()->getRowArray();

        return view('admin/diskusi/kelas', [
            'komentar' => $komentar,
            'kelas' => $kelas,
        ]);
    }

    // Hapus komentar
    public function hapusDiskusi($id)
    {
        $diskusiModel = new DiskusiModel();
        $diskusiModel->delete($id);

        return redirect()->back()->with('success', 'Komentar berhasil dihapus.');
    }

}
