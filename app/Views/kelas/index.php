<?php
session();
$nama = session()->get('nama');
$email = session()->get('email');
$role = session()->get('role');
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Kelas - SekulLegend</title>
    <!-- Tailwind CSS via CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Google -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Poppins', 'sans-serif'],
                    },
                    colors: {
                        burlap: {
                            50: '#f9f7f4',
                            100: '#f3efe8',
                            200: '#e6dfd1',
                            300: '#d8caae',
                            400: '#c7b28a',
                            500: '#b79e6f',
                            600: '#a58a5c',
                            700: '#8a724d',
                            800: '#735d42',
                            900: '#5f4d38',
                        }
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-burlap-50 font-sans min-h-screen">
    <!-- Gradient Background -->
    <div class="fixed inset-0 bg-gradient-to-br from-amber-50 to-stone-200 -z-10"></div>

    <!-- Navigation -->
    <nav class="bg-white shadow-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <div class="flex-shrink-0 flex items-center">
                        <h1 class="text-2xl font-bold text-stone-800">Sekul<span class="text-amber-700">Legend</span></h1>
                    </div>
                </div>
                <div class="flex items-center">
                    <div class="ml-4 flex items-center md:ml-6">
                        <div class="relative">
                            <button onclick="toggleDropdown()" class="flex items-center gap-2 text-sm">
                                <div class="w-8 h-8 bg-amber-100 text-amber-700 font-semibold flex items-center justify-center rounded-full">
                                    <?= substr($nama, 0, 1) ?>
                                </div>
                                <span class="hidden md:inline"><?= esc($nama) ?></span>
                                <svg class="w-5 h-5 text-stone-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path d="M19 9l-7 7-7-7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </button>
                            <div id="userDropdown" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg z-50">
                                <a href="<?= base_url('/kelas/edit-profil') ?>" class="block px-4 py-2 text-sm hover:bg-amber-50">Profil Saya</a>
                                <div class="border-t border-stone-200"></div>
                                <a href="<?= base_url('logout') ?>" class="block px-4 py-2 text-sm text-red-600 hover:bg-red-50">Logout</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header Banner -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden mb-8">
            <div class="md:flex">
                <div class="p-8">
                    <div class="uppercase tracking-wide text-sm text-amber-700 font-semibold">DAFTAR KELAS</div>
                    <h1 class="mt-2 text-3xl font-bold text-stone-800">Halo, <?= esc($nama) ?>!</h1>
                    <p class="mt-3 text-stone-600">Anda login sebagai <span class="font-semibold"><?= esc($role) ?></span>. 
                    <?php if ($role === 'guru'): ?>
                        Kelola semua kelas yang Anda buat.
                    <?php else: ?>
                        Gabung dan akses semua kelas pembelajaran Anda.
                    <?php endif; ?>
                    </p>
                </div>
            </div>
        </div>

        <?php if (session()->getFlashdata('success')): ?>
            <div class="bg-green-100 text-green-800 p-4 rounded-md mb-6 shadow-sm border border-green-200">
                <?= session()->getFlashdata('success') ?>
            </div>
        <?php endif; ?>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Kolom Kiri: Aksi -->
            <div class="md:col-span-1">
                <div class="bg-white rounded-xl shadow-md overflow-hidden">
                    <div class="px-6 py-4 border-b border-burlap-200 bg-burlap-50">
                        <h2 class="text-xl font-bold text-amber-700 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-amber-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" />
                            </svg>
                            Menu Aksi
                        </h2>
                    </div>
                    <div class="p-6">
                        <ul class="space-y-3">
                            <?php if ($role === 'guru'): ?>
                                <li>
                                    <a href="<?= base_url('/kelas/tambah') ?>" class="flex items-center text-burlap-700 hover:text-burlap-900 transition">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                        </svg>
                                        Buat Kelas Baru
                                    </a>
                                </li>
                            <?php else: ?>
                                <li>
                                    <a href="<?= base_url('/siswa/cek-kode-kelas') ?>" class="flex items-center text-burlap-700 hover:text-burlap-900 transition">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122" />
                                        </svg>
                                        Gabung Kelas
                                    </a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Kolom Kanan: Daftar Kelas -->
            <div class="md:col-span-2">
                <?php if ($role === 'guru'): ?>
                    <div class="bg-white rounded-xl shadow-md overflow-hidden">
                        <div class="px-6 py-4 border-b border-burlap-200 bg-burlap-50">
                            <h2 class="text-xl font-bold text-amber-700 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-amber-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                </svg>
                                Daftar Kelas yang Anda Buat
                            </h2>
                        </div>
                        <div class="divide-y divide-burlap-200">
                            <?php if (empty($kelas)): ?>
                                <div class="p-6 flex flex-col items-center justify-center text-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-burlap-500 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <p class="text-burlap-600 mb-2">Belum ada kelas yang dibuat.</p>
                                    <p class="text-stone-600 text-sm">Klik "Buat Kelas Baru" untuk mulai membuat kelas pembelajaran.</p>
                                </div>
                            <?php else: ?>
                                <?php foreach ($kelas as $k): ?>
                                    <div class="p-6 hover:bg-burlap-50/50 transition">
                                        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                                            <div>
                                                <h3 class="text-lg font-medium text-stone-800"><?= esc($k['nama_kelas']) ?></h3>
                                                <p class="text-sm text-burlap-600">Kode: <span class="font-semibold"><?= esc($k['kode_kelas']) ?></span></p>
                                            </div>
                                            <div class="mt-3 md:mt-0 flex flex-wrap gap-2">
                                                <a href="<?= base_url('/kelas/edit/' . $k['id']) ?>" class="px-3 py-1.5 bg-blue-100 text-blue-700 rounded-md text-sm font-medium hover:bg-blue-200 transition flex items-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                    </svg>
                                                    Edit
                                                </a>
                                                <a href="<?= base_url('/kelas/tambahMateri/' . $k['id']) ?>" class="px-3 py-1.5 bg-green-100 text-green-700 rounded-md text-sm font-medium hover:bg-green-200 transition flex items-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                    </svg>
                                                    Tambah Materi
                                                </a>
                                                <a href="<?= base_url('/materi/kelas/' . $k['id']) ?>" class="px-3 py-1.5 bg-indigo-100 text-indigo-700 rounded-md text-sm font-medium hover:bg-indigo-200 transition flex items-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                                    </svg>
                                                    Lihat Materi
                                                </a>
                                                <a href="<?= base_url('/kelas/diskusi/' . $k['id']) ?>" class="px-3 py-1.5 bg-purple-100 text-purple-700 rounded-md text-sm font-medium hover:bg-purple-200 transition flex items-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                                                    </svg>
                                                    Diskusi
                                                </a>
                                                <a href="<?= base_url('/kelas/hapus/' . $k['id']) ?>" class="px-3 py-1.5 bg-red-100 text-red-700 rounded-md text-sm font-medium hover:bg-red-200 transition flex items-center" onclick="return confirm('Yakin ingin menghapus kelas ini?')">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                    Hapus
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php else: ?>
                    <!-- Konten untuk siswa bisa ditambahkan di sini jika diperlukan -->
                    <div class="bg-white rounded-xl shadow-md overflow-hidden">
                        <div class="px-6 py-4 border-b border-burlap-200 bg-burlap-50">
                            <h2 class="text-xl font-bold text-amber-700 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-amber-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                </svg>
                                Daftar Kelas Saya
                            </h2>
                        </div>
                        <div class="divide-y divide-burlap-200">
                            <?php if (empty($kelas)): ?>
                                <div class="p-6 flex flex-col items-center justify-center text-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-burlap-500 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                    </svg>
                                    <p class="text-red-600 mb-2">Belum tergabung di kelas manapun.</p>
                                    <p class="text-stone-800 text-sm">Masukkan kode kelas untuk mulai belajar.</p>
                                </div>
                            <?php else: ?>
                                <?php foreach ($kelas as $k): ?>
                                    <div class="px-6 py-4 hover:bg-burlap-50/50 transition">
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center">
                                                <div class="p-2 rounded-md bg-green-100">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                                    </svg>
                                                </div>
                                                <div class="ml-3">
                                                    <h3 class="text-lg font-medium text-stone-800"><?= esc($k['nama_kelas']) ?></h3>
                                                </div>
                                            </div>
                                            <a href="<?= base_url('siswa/kelas/' . $k['id']) ?>" class="px-4 py-2 bg-blue-400 hover:bg-blue-500 text-white rounded-lg text-sm font-medium shadow-sm transition flex items-center">
                                                <span>Masuk Kelas</span>
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                                </svg>
                                            </a>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-white mt-1 border-t border-stone-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="md:flex md:items-center md:justify-between">
                <div class="flex justify-center md:justify-start">
                    <h1 class="text-xl font-bold text-stone-800">Sekul<span class="text-amber-700">Legend</span></h1>
                </div>
                <div class="mt-4 md:mt-0">
                    <p class="text-center md:text-right text-sm text-stone-500">&copy; 2023 SekulLegend. All rights reserved.</p>
                </div>
            </div>
        </div>
    </footer>

    <script>
        function toggleDropdown() {
            document.getElementById('userDropdown').classList.toggle('hidden');
        }
        
        // Tutup dropdown jika klik di luar
        window.addEventListener('click', function(e) {
            if (!e.target.closest('button') && !document.getElementById('userDropdown').classList.contains('hidden')) {
                document.getElementById('userDropdown').classList.add('hidden');
            }
        });
    </script>
</body>
</html>