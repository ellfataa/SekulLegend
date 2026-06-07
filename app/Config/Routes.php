<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// =========================
// Auth Routes
// =========================
$routes->get('/', 'Auth::login');
$routes->get('login', 'Auth::login');
$routes->post('login', 'Auth::loginProcess');
$routes->get('register', 'Auth::register');
$routes->post('register', 'Auth::registerProcess');
$routes->get('logout', 'Auth::logout');


// =========================
// Role Admin
// =========================
$routes->group('admin', static function ($routes) {
    $routes->get('/', 'Admin::index');
    $routes->get('dashboard', 'Admin::dashboard');

    // CRUD User
    $routes->get('user', 'Admin::manajemenUser');
    $routes->get('user/tambah', 'Admin::tambahUser');
    $routes->post('user/simpan', 'Admin::simpanUser');
    $routes->get('user/edit/(:num)', 'Admin::editUser/$1');
    $routes->post('user/update/(:num)', 'Admin::updateUser/$1');

    // Sementara tetap GET agar cocok dengan view lama.
    // Lebih aman nanti diganti POST.
    $routes->get('user/hapus/(:num)', 'Admin::hapusUser/$1');
    $routes->post('user/hapus/(:num)', 'Admin::hapusUser/$1');

    // CRUD Kelas
    $routes->get('kelas', 'Admin::kelas');
    $routes->get('kelas/tambah', 'Admin::tambahKelas');
    $routes->post('kelas/simpan', 'Admin::simpanKelas');
    $routes->get('kelas/edit/(:num)', 'Admin::editKelas/$1');
    $routes->post('kelas/update/(:num)', 'Admin::updateKelas/$1');

    // Sementara tetap GET agar cocok dengan view lama.
    // Lebih aman nanti diganti POST.
    $routes->get('kelas/hapus/(:num)', 'Admin::hapusKelas/$1');
    $routes->post('kelas/hapus/(:num)', 'Admin::hapusKelas/$1');

    // CRUD Materi
    $routes->get('materi', 'Admin::materi');
    $routes->get('materi/tambah', 'Admin::tambahMateri');
    $routes->post('materi/simpan', 'Admin::simpanMateri');
    $routes->get('materi/edit/(:num)', 'Admin::editMateri/$1');
    $routes->post('materi/update/(:num)', 'Admin::updateMateri/$1');

    // Sementara tetap GET agar cocok dengan view lama.
    // Lebih aman nanti diganti POST.
    $routes->get('materi/hapus/(:num)', 'Admin::hapusMateri/$1');
    $routes->post('materi/hapus/(:num)', 'Admin::hapusMateri/$1');

    // Diskusi
    $routes->get('diskusi', 'Admin::diskusi');
    $routes->get('diskusi/kelas/(:num)', 'Admin::diskusiKelas/$1');
    $routes->post('diskusi/hapus/(:num)', 'Admin::hapusDiskusi/$1');
});


// =========================
// Role Guru - Kelas
// =========================
$routes->group('kelas', static function ($routes) {
    $routes->get('/', 'Kelas::index');
    $routes->get('tambah', 'Kelas::tambah');
    $routes->post('simpan', 'Kelas::simpan');
    $routes->get('edit/(:num)', 'Kelas::edit/$1');
    $routes->post('update/(:num)', 'Kelas::update/$1');

    // Sementara tetap GET agar cocok dengan view lama.
    // Lebih aman nanti diganti POST.
    $routes->get('hapus/(:num)', 'Kelas::hapus/$1');
    $routes->post('hapus/(:num)', 'Kelas::hapus/$1');

    // Materi terkait kelas
    $routes->get('tambahMateri/(:num)', 'Kelas::tambahMateri/$1');
    $routes->post('simpanMateri', 'Kelas::simpanMateri');

    // Diskusi Guru
    $routes->get('diskusi/(:num)', 'Kelas::diskusi/$1');
    $routes->post('diskusi/(:num)/kirim', 'Kelas::kirimDiskusi/$1');
    $routes->get('edit-diskusi/(:num)', 'Kelas::editDiskusi/$1');
    $routes->post('update-diskusi/(:num)', 'Kelas::updateDiskusi/$1');

    // Sementara tetap GET agar cocok dengan view lama.
    // Lebih aman nanti diganti POST.
    $routes->get('hapus-diskusi/(:num)/(:num)', 'Kelas::hapusDiskusi/$1/$2');
    $routes->post('hapus-diskusi/(:num)/(:num)', 'Kelas::hapusDiskusi/$1/$2');

    // Profil Guru
    $routes->get('edit-profil', 'Kelas::editProfil');
    $routes->post('update-profil', 'Kelas::updateProfil');
});


// =========================
// Alias Role Guru
// =========================
$routes->get('guru', static function () {
    return redirect()->to('/kelas');
});

$routes->get('guru/kelas', static function () {
    return redirect()->to('/kelas');
});

$routes->get('guru/edit-profil', static function () {
    return redirect()->to('/kelas/edit-profil');
});

$routes->post('guru/update-profil', 'Kelas::updateProfil');


// =========================
// Materi Guru
// =========================
$routes->group('materi', static function ($routes) {
    $routes->get('kelas/(:num)', 'Materi::index/$1');
    $routes->get('edit/(:num)', 'Materi::edit/$1');
    $routes->post('update/(:num)', 'Materi::update/$1');

    // Sementara tetap GET agar cocok dengan view lama.
    // Lebih aman nanti diganti POST.
    $routes->get('hapus/(:num)', 'Materi::hapus/$1');
    $routes->post('hapus/(:num)', 'Materi::hapus/$1');

    $routes->get('download/(:segment)', 'Materi::download/$1');
});


// =========================
// Role Siswa
// =========================
$routes->group('siswa', static function ($routes) {
    $routes->get('/', static function () {
        return redirect()->to('/siswa/dashboard');
    });

    $routes->get('dashboard', 'Siswa::index');
    $routes->get('kelas', 'Siswa::kelas');
    $routes->get('kelas/(:num)', 'Siswa::kelasDetail/$1');

    // Masuk kelas dengan kode
    $routes->post('cek-kode-kelas', 'Siswa::cekKodeKelas');

    // Diskusi Siswa
    $routes->post('kelas/(:num)/kirim', 'Siswa::kirimKomentar/$1');
    $routes->get('edit-diskusi/(:num)', 'Siswa::editDiskusi/$1');
    $routes->post('update-diskusi/(:num)', 'Siswa::updateDiskusi/$1');

    // Sementara tetap GET agar cocok dengan view lama.
    // Lebih aman nanti diganti POST.
    $routes->get('hapus-diskusi/(:num)/(:num)', 'Siswa::hapusDiskusi/$1/$2');
    $routes->post('hapus-diskusi/(:num)/(:num)', 'Siswa::hapusDiskusi/$1/$2');

    // Profil Siswa
    $routes->get('edit-profil', 'Siswa::editProfil');
    $routes->post('update-profil', 'Siswa::updateProfil');

    // Download materi siswa, jika method ini memang ada di Siswa controller
    $routes->get('download-materi/(:any)', 'Siswa::downloadMateri/$1');
});


// =========================
// Download Materi Alias
// =========================
$routes->get('guru/download-materi/(:any)', 'Guru::downloadMateri/$1');