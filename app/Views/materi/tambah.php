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
    <title>Tambah Materi - SekulLegend</title>
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
        <!-- Tombol kembali ke detail kelas -->
        <div class="mb-4 flex">
            <a href="<?= base_url('/kelas') ?>" class="inline-flex items-center text-burlap-600 hover:text-burlap-800 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali ke Dashboard
            </a>
        </div>

        <!-- Header Banner -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden mb-8">
            <div class="p-8">
                <div class="uppercase tracking-wide text-sm text-amber-700 font-semibold">PEMBELAJARAN</div>
                <h1 class="mt-2 text-3xl font-bold text-stone-800">📚 Tambah Materi Baru</h1>
                <p class="mt-3 text-stone-600">Tambahkan materi pembelajaran untuk siswa Anda dengan melengkapi form di bawah ini.</p>
            </div>
        </div>
        
        <!-- Form Tambah Materi -->
        <div class="max-w-3xl mx-auto">
            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                <div class="px-6 py-4 border-b border-burlap-200 bg-burlap-50">
                    <h2 class="text-xl font-bold text-amber-700 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-amber-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Informasi Materi
                    </h2>
                </div>
                <div class="p-6">
                    <form action="<?= base_url('/kelas/simpanMateri') ?>" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="id_kelas" value="<?= $id_kelas ?>">
                        
                        <div class="mb-5">
                            <label for="judul" class="block text-sm font-medium text-stone-800 mb-1">Judul Materi <span class="text-red-500">*</span></label>
                            <input 
                                type="text" 
                                id="judul" 
                                name="judul" 
                                required 
                                placeholder="Contoh: Pengenalan Matematika Dasar" 
                                class="w-full p-3 border border-burlap-200 rounded-md focus:ring-2 focus:ring-burlap-500 focus:border-burlap-500 bg-burlap-50/50"
                            >
                        </div>
                        
                        <div class="mb-5">
                            <label for="deskripsi" class="block text-sm font-medium text-stone-800 mb-1">Deskripsi Materi</label>
                            <textarea 
                                id="deskripsi" 
                                name="deskripsi" 
                                rows="5" 
                                placeholder="Berikan deskripsi singkat tentang materi pembelajaran ini..." 
                                class="w-full p-3 border border-burlap-200 rounded-md focus:ring-2 focus:ring-burlap-500 focus:border-burlap-500 bg-burlap-50/50"
                            ></textarea>
                            <p class="text-xs text-burlap-500 mt-1">Deskripsi membantu siswa memahami isi materi sebelum mengunduh file.</p>
                        </div>
                        
                        <div class="mb-6">
                            <label for="file" class="block text-sm font-medium text-stone-800 mb-1">Upload File Materi</label>
                            <div class="relative border border-dashed border-burlap-300 rounded-md p-6 bg-blue-50">
                                <input 
                                    type="file" 
                                    id="file" 
                                    name="file" 
                                    class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                                >
                                <div class="text-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-12 w-12 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                    </svg>
                                    <p class="mt-1 text-sm text-blue-700">Drag and drop file atau <span class="font-medium text-blue-600">klik untuk memilih</span></p>
                                    <p class="mt-1 text-xs text-blue-500">Format yang didukung: PDF, DOC, DOCX, PPT, PPTX, XLS, XLSX (Maks. 10MB)</p>
                                </div>
                                <p id="selectedFileName" class="mt-2 text-sm text-center text-burlap-600 font-medium"></p>
                            </div>
                        </div>
                        
                        <div class="flex items-center justify-between border-t border-burlap-200 pt-5">
                            <a 
                                href="<?= base_url('/kelas') ?>" 
                                class="text-red-600 hover:text-red-800 px-4 py-2 border border-red-300 rounded-md hover:bg-red-50 transition flex items-center"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                                Batal
                            </a>
                            <button 
                                type="submit" 
                                class="bg-green-400 text-white px-6 py-2 rounded-md hover:bg-green-600 transition shadow-sm flex items-center"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                Simpan Materi
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            
            <div class="mt-6 text-center text-sm text-burlap-500">
                <p>Materi akan langsung tersedia untuk siswa setelah disimpan.</p>
                <p class="mt-1">Pastikan ukuran file tidak melebihi batas yang ditentukan.</p>
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
        
        // Menampilkan nama file setelah dipilih
        document.getElementById('file').addEventListener('change', function(e) {
            var fileName = e.target.files[0] ? e.target.files[0].name : '';
            document.getElementById('selectedFileName').textContent = fileName;
        });
    </script>
</body>
</html>