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
    <title>Buat Kelas - SekulLegend</title>
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

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Tombol kembali ke dashboard -->
        <div class="mb-4 flex">
            <a href="<?= base_url('/kelas') ?>" class="inline-flex items-center text-burlap-600 hover:text-burlap-800 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali ke Dashboard
            </a>
        </div>
        
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <div class="px-6 py-4 border-b border-burlap-200 bg-burlap-50">
                <h2 class="text-xl font-bold text-amber-700 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-amber-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    Formulir Kelas Baru
                </h2>
            </div>
            <div class="p-6">
                <?php if (session()->getFlashdata('error')): ?>
                    <div class="bg-red-100 text-red-700 p-3 rounded-md mb-4">
                        <?= session()->getFlashdata('error') ?>
                    </div>
                <?php endif; ?>
                
                <?php if (session()->getFlashdata('success')): ?>
                    <div class="bg-green-100 text-green-700 p-3 rounded-md mb-4">
                        <?= session()->getFlashdata('success') ?>
                    </div>
                <?php endif; ?>
                
                <form action="<?= base_url('/kelas/simpan') ?>" method="post" class="mb-6">
                    <div class="mb-4">
                        <label for="nama_kelas" class="block text-sm font-medium text-stone-800 mb-1">Nama Kelas</label>
                        <input 
                            type="text" 
                            id="nama_kelas"
                            name="nama_kelas" 
                            required 
                            placeholder="Contoh: Matematika Kelas 10" 
                            class="w-full p-3 border border-burlap-200 rounded-md focus:ring-2 focus:ring-burlap-500 focus:border-burlap-500 bg-burlap-50/50"
                        >
                        <p class="text-xs text-burlap-500 mt-1">Masukkan nama kelas yang ingin dibuat</p>
                    </div>
                    <button 
                        type="submit" 
                        class="w-full md:w-auto bg-green-400 text-white px-6 py-3 rounded-md hover:bg-green-600 transition shadow-sm flex items-center justify-center"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Simpan Kelas
                    </button>
                </form>
            </div>
        </div>
    </div>

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