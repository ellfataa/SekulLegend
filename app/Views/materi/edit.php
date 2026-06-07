<?php
$nama = session()->get('nama') ?? 'Pengguna';

$materi = isset($materi) && is_array($materi)
  ? $materi
  : [
      'id'        => '',
      'id_kelas'  => '',
      'judul'     => '',
      'deskripsi' => '',
      'file'      => '',
    ];
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>Edit Materi - SekulLegend</title>

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
    <section class="w-full max-w-3xl">

      <!-- Back Button -->
      <div class="mb-5">
        <a
          href="<?= base_url('/materi/kelas/' . ($materi['id_kelas'] ?? '')) ?>"
          class="inline-flex items-center gap-2 text-sm font-medium text-burlap-700 transition hover:text-burlap-900"
        >
          <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
          </svg>
          Kembali ke Daftar Materi
        </a>
      </div>

      <!-- Card -->
      <div class="overflow-hidden rounded-2xl border border-burlap-200 bg-white/90 shadow-xl backdrop-blur-sm">
        <div class="border-b border-burlap-200 bg-burlap-50 px-6 py-5">
          <h1 class="flex items-center gap-2 text-xl font-bold text-amber-700">
            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
            </svg>
            Edit Materi
          </h1>

          <p class="mt-2 text-sm text-stone-500">
            Perbarui informasi materi. Kosongkan file jika tidak ingin mengubah file.
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

          <form action="<?= base_url('/materi/update/' . ($materi['id'] ?? '')) ?>" method="post" enctype="multipart/form-data" class="space-y-5">
            <?= csrf_field() ?>

            <div>
              <label for="judul" class="mb-2 block text-sm font-medium text-stone-700">
                Judul Materi
              </label>

              <input
                type="text"
                id="judul"
                name="judul"
                value="<?= esc(old('judul', $materi['judul'] ?? '')) ?>"
                required
                class="w-full rounded-lg border border-burlap-200 bg-burlap-50/50 px-4 py-3 text-sm text-stone-800 outline-none transition placeholder:text-stone-400 focus:border-burlap-500 focus:ring-2 focus:ring-burlap-200"
              >
            </div>

            <div>
              <label for="deskripsi" class="mb-2 block text-sm font-medium text-stone-700">
                Deskripsi Materi
              </label>

              <textarea
                id="deskripsi"
                name="deskripsi"
                rows="5"
                class="w-full rounded-lg border border-burlap-200 bg-burlap-50/50 px-4 py-3 text-sm text-stone-800 outline-none transition placeholder:text-stone-400 focus:border-burlap-500 focus:ring-2 focus:ring-burlap-200"
              ><?= esc(old('deskripsi', $materi['deskripsi'] ?? '')) ?></textarea>
            </div>

            <div>
              <label for="file" class="mb-2 block text-sm font-medium text-stone-700">
                File Materi
              </label>

              <input
                type="file"
                id="file"
                name="file"
                class="w-full rounded-lg border border-burlap-200 bg-burlap-50/50 px-4 py-3 text-sm text-stone-800 outline-none transition file:mr-4 file:rounded-lg file:border-0 file:bg-burlap-600 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-white hover:file:bg-burlap-700"
              >

              <?php if (! empty($materi['file'])) : ?>
                <p class="mt-3 text-sm text-stone-600">
                  File saat ini:
                  <a
                    href="<?= base_url('uploads/materi/' . ($materi['file'] ?? '')) ?>"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="font-semibold text-amber-700 hover:text-amber-800 hover:underline"
                  >
                    <?= esc($materi['file']) ?>
                  </a>
                </p>

                <p class="mt-1 text-xs text-stone-500">
                  Kosongkan jika tidak ingin mengubah file.
                </p>
              <?php endif; ?>
            </div>

            <div class="flex flex-col gap-3 pt-2 sm:flex-row">
              <button
                type="submit"
                class="inline-flex w-full items-center justify-center gap-2 rounded-lg bg-green-600 px-5 py-3 text-sm font-semibold text-white shadow-md transition hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 sm:w-auto"
              >
                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
                </svg>
                Simpan Perubahan
              </button>

              <a
                href="<?= base_url('/materi/kelas/' . ($materi['id_kelas'] ?? '')) ?>"
                class="inline-flex w-full items-center justify-center rounded-lg border border-red-300 px-5 py-3 text-sm font-semibold text-red-600 transition hover:bg-red-50 sm:w-auto"
              >
                Batal
              </a>
            </div>
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