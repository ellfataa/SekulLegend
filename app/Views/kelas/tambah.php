<?php
$nama = session()->get('nama') ?? 'Pengguna';
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>Buat Kelas - SekulLegend</title>

  <!-- Tailwind CSS -->
  <script src="https://cdn.tailwindcss.com"></script>

  <!-- Google Font -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
    rel="stylesheet"
  >

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
            },
          },
        },
      },
    };
  </script>
</head>

<body class="min-h-screen bg-gradient-to-br from-amber-50 via-orange-50 to-stone-200 font-sans text-stone-800">
  <main class="flex min-h-screen items-center justify-center px-4 py-8">
    <section class="w-full max-w-2xl">

      <!-- Back Button -->
      <div class="mb-5">
        <a
          href="<?= base_url('/kelas') ?>"
          class="inline-flex items-center gap-2 text-sm font-medium text-burlap-700 transition hover:text-burlap-900"
        >
          <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
          </svg>
          Kembali ke Daftar Kelas
        </a>
      </div>

      <!-- Card -->
      <div class="overflow-hidden rounded-2xl border border-burlap-200 bg-white/90 shadow-xl backdrop-blur-sm">
        <div class="border-b border-burlap-200 bg-burlap-50 px-6 py-5">
          <h1 class="flex items-center gap-2 text-xl font-bold text-amber-700">
            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v12m6-6H6" />
            </svg>
            Formulir Kelas Baru
          </h1>

          <p class="mt-2 text-sm text-stone-500">
            Buat kelas baru agar siswa dapat bergabung menggunakan kode kelas.
          </p>
        </div>

        <div class="p-6">
          <?php if (session()->getFlashdata('error')) : ?>
            <div class="mb-5 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
              <?= esc(session()->getFlashdata('error')) ?>
            </div>
          <?php endif; ?>

          <?php if (session()->getFlashdata('success')) : ?>
            <div class="mb-5 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
              <?= esc(session()->getFlashdata('success')) ?>
            </div>
          <?php endif; ?>

          <form action="<?= base_url('/kelas/simpan') ?>" method="post" class="space-y-5">
            <?= csrf_field() ?>

            <div>
              <label for="nama_kelas" class="mb-2 block text-sm font-medium text-stone-700">
                Nama Kelas
              </label>

              <input
                type="text"
                id="nama_kelas"
                name="nama_kelas"
                value="<?= esc(old('nama_kelas')) ?>"
                required
                placeholder="Contoh: Matematika Kelas 10"
                class="w-full rounded-lg border border-burlap-200 bg-burlap-50/50 px-4 py-3 text-sm text-stone-800 outline-none transition placeholder:text-stone-400 focus:border-burlap-500 focus:ring-2 focus:ring-burlap-200"
              >

              <p class="mt-2 text-xs text-burlap-600">
                Masukkan nama kelas yang ingin dibuat.
              </p>
            </div>

            <button
              type="submit"
              class="inline-flex w-full items-center justify-center gap-2 rounded-lg bg-green-600 px-5 py-3 text-sm font-semibold text-white shadow-md transition hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 sm:w-auto"
            >
              <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
              </svg>
              Simpan Kelas
            </button>
          </form>
        </div>
      </div>

      <p class="mt-6 text-center text-sm text-stone-500">
        &copy; 2023 SekulLegend. All rights reserved.
      </p>
    </section>
  </main>
</body>
</html>