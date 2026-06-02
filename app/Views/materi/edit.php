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
    <title>Edit Materi - SekulLegend</title>
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
        <!-- Tombol kembali ke daftar materi -->
        <div class="mb-4 flex">
            <a href="<?= base_url('/materi/kelas/' . $materi['id_kelas']) ?>" class="inline-flex items-center text-burlap-600 hover:text-burlap-800 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali ke Daftar Materi Kelas
            </a>
        </div>

        <!-- Header Banner -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden mb-8">
            <div class="md:flex">
                <div class="p-8">
                    <div class="uppercase tracking-wide text-sm text-amber-700 font-semibold">MANAJEMEN MATERI</div>
                    <h1 class="mt-2 text-3xl font-bold text-stone-800">Edit Materi</h1>
                    <p class="mt-3 text-stone-600">Perbarui informasi dan file materi pembelajaran Anda.</p>
                </div>
            </div>
        </div>
        
        <!-- Form Edit Materi -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <div class="px-6 py-4 border-b border-burlap-200 bg-burlap-50">
                <h2 class="text-xl font-bold text-amber-700 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-amber-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Form Edit Materi
                </h2>
            </div>
            
            <div class="p-6">
                <?php if (session()->getFlashdata('error')): ?>
                    <div class="bg-red-100 text-red-800 px-4 py-3 rounded-lg mb-6 border border-red-200">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium"><?= session()->getFlashdata('error') ?></p>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if (session()->getFlashdata('success')): ?>
                    <div class="bg-green-100 text-green-800 px-4 py-3 rounded-lg mb-6 border border-green-200">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium"><?= session()->getFlashdata('success') ?></p>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <form action="<?= base_url('/materi/update/' . $materi['id']) ?>" method="post" enctype="multipart/form-data">
                    <div class="space-y-6">
                        <div>
                            <label for="judul" class="block text-sm font-medium text-stone-800 mb-1">Judul Materi</label>
                            <input 
                                type="text" 
                                id="judul" 
                                name="judul" 
                                value="<?= esc($materi['judul']) ?>" 
                                class="w-full p-3 border border-burlap-200 rounded-md focus:ring-2 focus:ring-burlap-500 focus:border-burlap-500 bg-burlap-50/50"
                                required
                            >
                        </div>

                        <div>
                            <label for="deskripsi" class="block text-sm font-medium text-stone-800 mb-1">Deskripsi Materi</label>
                            <textarea 
                                id="deskripsi" 
                                name="deskripsi" 
                                rows="4" 
                                class="w-full p-3 border border-burlap-200 rounded-md focus:ring-2 focus:ring-burlap-500 focus:border-burlap-500 bg-burlap-50/50"
                                required
                            ><?= esc($materi['deskripsi']) ?></textarea>
                        </div>

                        <div>
                            <label for="file" class="block text-sm font-medium text-stone-800 mb-1">File Materi</label>
                            <div class="mt-1 flex items-center">
                                <span class="inline-block h-12 w-12 rounded-md overflow-hidden bg-green-100">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-full w-full text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                </span>
                                <input 
                                    type="file" 
                                    id="file" 
                                    name="file" 
                                    class="ml-5 py-2 px-3 border border-burlap-200 rounded-md text-sm focus:outline-none bg-burlap-50/50"
                                >
                            </div>
                            <?php if (!empty($materi['file'])): ?>
                                <p class="mt-2 text-sm text-stone-600">
                                    File saat ini: 
                                    <a href="<?= base_url('public/uploads/materi/' . $materi['file']) ?>" target="_blank" class="text-amber-700 hover:text-amber-800 font-medium hover:underline">
                                        <?= esc($materi['file']) ?>
                                    </a>
                                </p>
                                <p class="mt-1 text-sm text-stone-500">Kosongkan jika tidak ingin mengubah file.</p>
                            <?php endif; ?>
                        </div>

                        <div class="pt-4 flex flex-wrap">
                            <button 
                                type="submit" 
                                class="w-full sm:w-auto bg-green-400 text-white px-6 py-3 rounded-md hover:bg-green-600 transition shadow-sm flex items-center justify-center"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
                                </svg>
                                Simpan Perubahan
                            </button>

                            <a 
                                href="<?= base_url('/materi/kelas/' . $materi['id_kelas']) ?>" 
                                class="mt-3 sm:mt-0 sm:ml-3 inline-flex items-center justify-center px-6 py-3 border border-red-300 shadow-sm text-red-700 bg-white rounded-md hover:bg-red-50 transition"
                            >
                                Batal
                            </a>
                        </div>
                    </div>
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