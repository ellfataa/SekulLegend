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
    <title>Diskusi Kelas - SekulLegend</title>
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
                        <a href="<?= base_url('admin/dashboard') ?>" class="px-3 py-2 rounded-md text-sm font-medium text-stone-600 hover:text-amber-700 hover:bg-amber-50">Dashboard</a>
                        <a href="<?= base_url('admin/user') ?>" class="px-3 py-2 rounded-md text-sm font-medium text-stone-600 hover:text-amber-700 hover:bg-amber-50">User</a>
                        <a href="<?= base_url('admin/kelas') ?>" class="px-3 py-2 rounded-md text-sm font-medium text-stone-600 hover:text-amber-700 hover:bg-amber-50">Kelas</a>
                        <a href="<?= base_url('admin/materi') ?>" class="px-3 py-2 rounded-md text-sm font-medium text-stone-600 hover:text-amber-700 hover:bg-amber-50">Materi</a>
                        <a href="<?= base_url('admin/diskusi') ?>" class="px-3 py-2 rounded-md text-sm font-medium text-amber-700 bg-amber-50">Diskusi</a>
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
                    <div class="uppercase tracking-wide text-sm text-amber-700 font-semibold">ADMIN AREA</div>
                    <h1 class="mt-2 text-3xl font-bold text-stone-800">Diskusi Kelas</h1>
                    <p class="mt-3 text-stone-600">Lihat dan kelola forum diskusi di setiap kelas pada platform SekulLegend.</p>
                </div>
            </div>
        </div>
        
        <!-- Tabel Diskusi Kelas -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <div class="px-6 py-4 border-b border-burlap-200 bg-burlap-50">
                <h2 class="text-xl font-bold text-amber-700 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-amber-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                    </svg>
                    Daftar Kelas dengan Diskusi
                </h2>
            </div>
            <div class="p-6">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-burlap-200 text-sm">
                        <thead>
                            <tr class="bg-burlap-50">
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-stone-700 uppercase tracking-wider">No</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-stone-700 uppercase tracking-wider">Nama Kelas</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-stone-700 uppercase tracking-wider">Total Diskusi</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-stone-700 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-burlap-100">
                            <?php $no = 1; foreach ($kelas as $k): ?>
                                <tr class="hover:bg-burlap-50 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap text-stone-700"><?= $no++ ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap font-medium text-stone-800"><?= esc($k['nama_kelas']) ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-3 py-1 inline-flex text-sm leading-5 font-medium rounded-full bg-amber-100 text-amber-800">
                                            <?= $k['total_diskusi'] ?>
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <a href="<?= base_url('admin/diskusi/kelas/' . $k['id']) ?>" class="inline-flex items-center px-3 py-1 border border-blue-600 text-blue-700 rounded-md hover:bg-blue-50 transition-colors">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                            Lihat Diskusi
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                            
                            <?php if (empty($kelas)): ?>
                                <tr>
                                    <td colspan="4" class="px-6 py-12 text-center text-stone-500 italic">Tidak ada data kelas yang tersedia</td>
                                </tr>
                            <?php endif ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-white mt-8 border-t border-stone-200">
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