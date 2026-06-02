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

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Tombol kembali ke daftar kelas -->
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
                <div class="uppercase tracking-wide text-sm text-amber-700 font-semibold">FORUM DISKUSI</div>
                <h1 class="mt-2 text-3xl font-bold text-stone-800">💬 Diskusi: <?= esc($kelas['nama_kelas']) ?></h1>
                <p class="mt-3 text-stone-600">Diskusikan materi pembelajaran dengan guru dan teman sekelas Anda.</p>
            </div>
        </div>
        
        <!-- Form Kirim Pesan -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden mb-6">
            <div class="px-6 py-4 border-b border-burlap-200 bg-burlap-50">
                <h2 class="text-xl font-bold text-amber-700 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-amber-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                    </svg>
                    Kirim Pesan
                </h2>
            </div>
            <div class="p-6">
                <form action="<?= base_url('/kelas/diskusi/' . $id_kelas . '/kirim') ?>" method="post">
                    <textarea 
                        name="pesan" 
                        class="w-full p-3 border border-burlap-200 rounded-md focus:ring-2 focus:ring-burlap-500 focus:border-burlap-500 bg-burlap-50/50" 
                        rows="3" 
                        placeholder="Tulis pesan diskusi Anda di sini..."
                        required
                    ></textarea>
                    <button 
                        type="submit" 
                        class="mt-3 bg-green-400 text-white px-4 py-2 rounded-md hover:bg-green-600 transition shadow-sm flex items-center"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                        </svg>
                        Kirim Pesan
                    </button>
                </form>
            </div>
        </div>

        <!-- Daftar Diskusi -->
        <div class="space-y-4">
            <?php if (empty($diskusi)): ?>
                <div class="bg-white rounded-xl shadow-md overflow-hidden p-6 text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-burlap-400 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                    </svg>
                    <p class="text-red-700 font-medium">Belum ada diskusi di kelas ini.</p>
                    <p class="text-burlap-500 text-sm mt-1">Mulailah percakapan dengan mengirim pesan pertama.</p>
                </div>
            <?php endif; ?>
            
            <?php foreach ($diskusi as $d): ?>
                <div class="bg-white rounded-xl shadow-md overflow-hidden">
                    <div class="px-6 py-4 border-b border-burlap-200 bg-burlap-50 flex justify-between items-center">
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-amber-100 text-amber-700 font-semibold flex items-center justify-center rounded-full">
                                <?= substr($userMap[$d['id_user']] ?? 'P', 0, 1) ?>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-stone-800"><?= esc($userMap[$d['id_user']] ?? 'Pengguna') ?></h3>
                                <p class="text-xs text-burlap-500"><?= date('d M Y H:i', strtotime($d['created_at'])) ?></p>
                            </div>
                        </div>
                        
                        <?php if (session()->get('id') == $d['id_user']): ?>
                        <div class="space-x-2">
                            <a href="<?= base_url('/kelas/edit-diskusi/' . $d['id']) ?>" class="text-sm text-blue-600 hover:text-blue-800 hover:underline">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                                Edit
                            </a>
                            <a href="<?= base_url('/kelas/hapus-diskusi/' . $d['id'] . '/' . $id_kelas) ?>" 
                            onclick="return confirm('Yakin ingin menghapus komentar ini?')" 
                            class="text-sm text-red-600 hover:text-red-800 hover:underline">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                                Hapus
                            </a>
                        </div>
                        <?php endif; ?>
                    </div>
                    <div class="p-6">
                        <p class="text-stone-800"><?= nl2br(esc($d['pesan'])) ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
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