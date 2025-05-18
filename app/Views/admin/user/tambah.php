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
    <title>Tambah User - SekulLegend</title>
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
                        <a href="<?= base_url('admin/user') ?>" class="px-3 py-2 rounded-md text-sm font-medium text-amber-700 bg-amber-50">User</a>
                        <a href="<?= base_url('admin/kelas') ?>" class="px-3 py-2 rounded-md text-sm font-medium text-stone-600 hover:text-amber-700 hover:bg-amber-50">Kelas</a>
                        <a href="<?= base_url('admin/materi') ?>" class="px-3 py-2 rounded-md text-sm font-medium text-stone-600 hover:text-amber-700 hover:bg-amber-50">Materi</a>
                        <a href="<?= base_url('admin/diskusi') ?>" class="px-3 py-2 rounded-md text-sm font-medium text-stone-600 hover:text-amber-700 hover:bg-amber-50">Diskusi</a>
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
                    <h1 class="mt-2 text-3xl font-bold text-stone-800">Tambah User</h1>
                    <p class="mt-3 text-stone-600">Tambahkan pengguna baru ke platform SekulLegend.</p>
                </div>
            </div>
        </div>
        
        <!-- Form Tambah User -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <div class="px-6 py-4 border-b border-burlap-200 bg-burlap-50">
                <h2 class="text-xl font-bold text-amber-700 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-amber-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                    </svg>
                    Tambah User Baru
                </h2>
            </div>
            <div class="p-6">
                <form action="<?= base_url('admin/user/simpan') ?>" method="post" class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="nama" class="block text-sm font-medium text-stone-700 mb-1">Nama Lengkap</label>
                            <input type="text" name="nama" id="nama" placeholder="Masukkan nama lengkap" required 
                                class="w-full px-3 py-2 border border-burlap-200 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                        </div>
                        <div>
                            <label for="username" class="block text-sm font-medium text-stone-700 mb-1">Username</label>
                            <input type="text" name="username" id="username" placeholder="Masukkan username" required 
                                class="w-full px-3 py-2 border border-burlap-200 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                        </div>
                    </div>
                    <div>
                        <label for="password" class="block text-sm font-medium text-stone-700 mb-1">Password</label>
                        <input type="password" name="password" id="password" placeholder="Masukkan password" required 
                            class="w-full px-3 py-2 border border-burlap-200 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                    </div>
                    <div>
                        <label for="role" class="block text-sm font-medium text-stone-700 mb-1">Role</label>
                        <select name="role" id="role" required 
                            class="w-full px-3 py-2 border border-burlap-200 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                            <option value="" disabled selected>Pilih role user</option>
                            <option value="guru">Guru</option>
                            <option value="siswa">Siswa</option>
                        </select>
                    </div>
                    <div class="flex justify-end pt-4">
                        <a href="<?= base_url('admin/user') ?>" class="px-4 py-2 bg-stone-200 text-stone-800 rounded-lg mr-2 font-medium hover:bg-stone-300 transition">
                            Batal
                        </a>
                        <button type="submit" class="px-4 py-2 bg-amber-600 text-white rounded-lg font-medium hover:bg-amber-700 transition flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Simpan
                        </button>
                    </div>
                </form>
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