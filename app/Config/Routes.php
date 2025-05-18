<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// 🔐 Auth Routes
$routes->get('/', 'Auth::login');
$routes->get('/login', 'Auth::login');
$routes->post('/login', 'Auth::loginProcess');
$routes->get('/register', 'Auth::register');
$routes->post('/register', 'Auth::registerProcess');
$routes->get('/logout', 'Auth::logout');

// 🛠️ Admin Dashboard
$routes->get('/admin/dashboard', 'Admin::dashboard');

// 📚 Kelas (Guru)
$routes->group('kelas', function ($routes) {
    $routes->get('/', 'Kelas::index');
    $routes->get('tambah', 'Kelas::tambah');
    $routes->post('simpan', 'Kelas::simpan');
    $routes->get('edit/(:num)', 'Kelas::edit/$1');
    $routes->post('update/(:num)', 'Kelas::update/$1');
    $routes->get('hapus/(:num)', 'Kelas::hapus/$1');

    // 📄 Materi terkait kelas
    $routes->get('tambahMateri/(:num)', 'Kelas::tambahMateri/$1');
    $routes->post('simpanMateri', 'Kelas::simpanMateri');

    // Update Profil (Guru)
    $routes->get('edit-profil', 'Kelas::editProfil');
    $routes->post('update-profil', 'Kelas::updateProfil');
});

// Edit Profil (Guru)
$routes->get('/guru/edit-profil', 'Guru::editProfil');
$routes->post('/guru/update-profil', 'Guru::updateProfil');


// 📄 Materi
$routes->get('/materi/kelas/(:num)', 'Materi::index/$1');
$routes->get('/materi/edit/(:num)', 'Materi::edit/$1');
$routes->post('/materi/update/(:num)', 'Materi::update/$1');
$routes->get('/materi/hapus/(:num)', 'Materi::hapus/$1');
$routes->get('/materi/download/(:segment)', 'Materi::download/$1');
$routes->get('guru/download-materi/(:any)', 'Guru::downloadMateri/$1');
$routes->get('public/uploads/materi/(:any)', 'Materi::download/$1');
$routes->get('siswa/download-materi/(:any)', 'Siswa::downloadMateri/$1');

// 💬 Diskusi (Guru)
$routes->get('/kelas/diskusi/(:num)', 'Kelas::diskusi/$1');
$routes->post('/kelas/diskusi/(:num)/kirim', 'Kelas::kirimDiskusi/$1');
$routes->get('/kelas/edit-diskusi/(:num)', 'Kelas::editDiskusi/$1');
$routes->post('/kelas/update-diskusi/(:num)', 'Kelas::updateDiskusi/$1');
$routes->get('/kelas/hapus-diskusi/(:num)/(:num)', 'Kelas::hapusDiskusi/$1/$2');

// 🎓 Role Siswa
$routes->get('/siswa', function () {
    return redirect()->to('/siswa/dashboard');
});
$routes->get('/siswa/dashboard', 'Siswa::index');
$routes->get('/siswa/kelas', 'Siswa::kelas');
$routes->get('/siswa/kelas/(:num)', 'Siswa::kelasDetail/$1');
$routes->post('/siswa/kelas/(:num)/kirim', 'Siswa::kirimKomentar/$1');
$routes->get('/siswa/edit-diskusi/(:num)', 'Siswa::editDiskusi/$1');
$routes->post('/siswa/update-diskusi/(:num)', 'Siswa::updateDiskusi/$1');
$routes->get('/siswa/hapus-diskusi/(:num)/(:num)', 'Siswa::hapusDiskusi/$1/$2');
// Masuk kode kelas
$routes->post('/siswa/cek-kode-kelas', 'Siswa::cekKodeKelas');
// Edit Profil

$routes->get('/siswa/edit-profil', 'Siswa::editProfil');
$routes->post('/siswa/update-profil', 'Siswa::updateProfil');

// Role Admin
$routes->get('/admin', 'Admin::index');
$routes->get('/admin/dashboard', 'Admin::dashboard');
    // CRUD User
    $routes->get('/admin/user', 'Admin::manajemenUser');
    $routes->get('/admin/user/tambah', 'Admin::tambahUser');
    $routes->post('/admin/user/simpan', 'Admin::simpanUser');
    $routes->get('/admin/user/edit/(:num)', 'Admin::editUser/$1');
    $routes->post('/admin/user/update/(:num)', 'Admin::updateUser/$1');
    $routes->get('/admin/user/hapus/(:num)', 'Admin::hapusUser/$1');
    // CRUD Kelas
    $routes->get('/admin/kelas', 'Admin::kelas');
    $routes->get('/admin/kelas/tambah', 'Admin::tambahKelas');

    $routes->post('/admin/kelas/simpan', 'Admin::simpanKelas');
    $routes->get('/admin/kelas/edit/(:num)', 'Admin::editKelas/$1');
    $routes->post('/admin/kelas/update/(:num)', 'Admin::updateKelas/$1');
    $routes->get('/admin/kelas/hapus/(:num)', 'Admin::hapusKelas/$1');
    // CRUD Materi
    $routes->get('/admin/materi', 'Admin::materi');
    $routes->get('/admin/materi/tambah', 'Admin::tambahMateri');
    $routes->post('/admin/materi/simpan', 'Admin::simpanMateri');
    $routes->get('/admin/materi/edit/(:num)', 'Admin::editMateri/$1');
    $routes->post('/admin/materi/update/(:num)', 'Admin::updateMateri/$1');
    $routes->get('/admin/materi/hapus/(:num)', 'Admin::hapusMateri/$1');
    // CRUD Diskusi
    $routes->get('admin/diskusi', 'Admin::diskusi');
    $routes->get('admin/diskusi/kelas/(:num)', 'Admin::diskusiKelas/$1');
    $routes->get('admin/diskusi/hapus/(:num)', 'Admin::hapusDiskusi/$1');
    $routes->post('admin/diskusi/hapus/(:num)', 'Admin::hapusDiskusi/$1');




