<?php
session();
$nama = session()->get('nama');
$email = session()->get('email');

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Kelas - SekulLegend</title>
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
                    <div class="hidden md:ml-6 md:flex md:items-center md:space-x-4">
                        <a href="<?= base_url('siswa/dashboard') ?>" class="px-3 py-2 rounded-md text-sm font-medium text-stone-600 hover:text-amber-700 hover:bg-amber-50">Dashboard</a>
                        <a href="<?= base_url('siswa/kelas') ?>" class="px-3 py-2 rounded-md text-sm font-medium text-amber-700 bg-amber-50">Kelas</a>
                    </div>
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
                                <a href="<?= base_url('/siswa/edit-profil') ?>" class="block px-4 py-2 text-sm hover:bg-amber-50">Profil Saya</a>
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
        <!-- Tombol kembali ke daftar kelas -->
        <div class="mb-4 flex">
            <a href="<?= base_url('/siswa/kelas') ?>" class="inline-flex items-center text-burlap-600 hover:text-burlap-800 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali ke Daftar Kelas
            </a>
        </div>

        <!-- Header Banner -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden mb-8">
            <div class="md:flex">
                <div class="p-8">
                    <div class="uppercase tracking-wide text-sm text-amber-700 font-semibold">DETAIL KELAS</div>
                    <h1 class="mt-2 text-3xl font-bold text-stone-800"><?= esc($kelas['nama_kelas']) ?></h1>
                    <p class="mt-3 text-stone-600">Akses materi dan diskusi pembelajaran di kelas ini.</p>
                </div>
            </div>
        </div>
        
        <!-- Content Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Kolom Kiri: Materi -->
            <div class="md:col-span-1">
                <div class="bg-white rounded-xl shadow-md overflow-hidden">
                    <div class="px-6 py-4 border-b border-burlap-200 bg-burlap-50">
                        <h2 class="text-xl font-bold text-amber-700 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-amber-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                            Materi Pembelajaran
                        </h2>
                    </div>
                    <div class="p-6">
                        <?php if (!empty($materi)): ?>
                            <ul class="space-y-3">
                                <?php foreach ($materi as $m): ?>
                                    <li class="flex items-start">
                                        <div class="flex-shrink-0 p-1 rounded-md bg-blue-100">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                        </div>
                                        <div class="ml-3">
                                            <a href="<?= base_url('public/uploads/materi/' . $m['file']) ?>" 
                                               class="text-blue-400 hover:text-blue-700 font-medium" 
                                               target="_blank">
                                                <?= esc($m['judul']) ?>
                                            </a>
                                        </div>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php else: ?>
                            <div class="flex flex-col items-center justify-center text-center py-6">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-burlap-300 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <p class="text-burlap-500">Belum ada materi pembelajaran.</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Kolom Kanan: Diskusi -->
            <div class="md:col-span-2">
                <div class="bg-white rounded-xl shadow-md overflow-hidden">
                    <div class="px-6 py-4 border-b border-burlap-200 bg-burlap-50">
                        <h2 class="text-xl font-bold text-amber-700 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-amber-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                            </svg>
                            Forum Diskusi
                        </h2>
                    </div>
                    <div class="p-6">
                        <!-- Form Kirim Komentar -->
                        <form action="<?= base_url('/siswa/kelas/' . $kelas['id'] . '/kirim') ?>" method="post" class="mb-6">
                            <div class="mb-3">
                                <label for="pesan" class="block text-sm font-medium text-stone-800 mb-1">Tulis Komentar</label>
                                <textarea 
                                    name="pesan" 
                                    id="pesan" 
                                    rows="3" 
                                    class="w-full p-3 border border-burlap-200 rounded-md focus:ring-2 focus:ring-burlap-500 focus:border-burlap-500 bg-burlap-50/50"
                                    placeholder="Tulis pesan diskusi..."
                                    required
                                ></textarea>
                            </div>
                            <button 
                                type="submit" 
                                class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 transition shadow-sm flex items-center justify-center"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                                </svg>
                                Kirim Pesan
                            </button>
                        </form>

                        <!-- Daftar Komentar -->
                        <div class="space-y-4">
                            <?php if (empty($diskusi)): ?>
                                <div class="flex flex-col items-center justify-center text-center py-6 bg-burlap-50/50 rounded-lg">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-burlap-300 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                    </svg>
                                    <p class="text-burlap-500">Belum ada diskusi. Mulai diskusi dengan mengirim pesan.</p>
                                </div>
                            <?php endif; ?>
                            
                            <?php foreach ($diskusi as $d): ?>
                                <div class="p-4 rounded-lg <?= session()->get('id') == $d['id_user'] ? 'bg-amber-50' : 'bg-burlap-50/50' ?> shadow-sm">
                                    <div class="flex items-center justify-between mb-2">
                                        <div class="flex items-center">
                                            <div class="w-8 h-8 bg-amber-100 text-amber-700 font-semibold flex items-center justify-center rounded-full">
                                                <?= substr($userMap[$d['id_user']] ?? 'P', 0, 1) ?>
                                            </div>
                                            <div class="ml-2">
                                                <p class="text-sm font-medium text-stone-800">
                                                    <?= esc($userMap[$d['id_user']] ?? 'Pengguna') ?>
                                                </p>
                                                <p class="text-xs text-stone-500">
                                                    <?= date('d M Y H:i', strtotime($d['created_at'])) ?>
                                                </p>
                                            </div>
                                        </div>
                                        
                                        <!-- Tindakan Edit/Hapus jika milik sendiri -->
                                        <?php if (session()->get('id') == $d['id_user']): ?>
                                            <div class="flex space-x-2">
                                                <a href="<?= base_url('/siswa/edit-diskusi/' . $d['id']) ?>" class="inline-flex items-center text-blue-600 text-sm hover:text-blue-800">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                    </svg>
                                                    Edit
                                                </a>
                                                <a href="<?= base_url('/siswa/hapus-diskusi/' . $kelas['id'] . '/' . $d['id']) ?>" 
                                                   class="inline-flex items-center text-red-600 text-sm hover:text-red-800" 
                                                   onclick="return confirm('Yakin ingin menghapus komentar ini?')">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                    Hapus
                                                </a>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="mt-2 text-stone-800">
                                        <?= nl2br(esc($d['pesan'])) ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
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