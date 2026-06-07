<?php
$nama = session()->get('nama') ?? 'Pengguna';
$id_kelas = $id_kelas ?? 0;
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>Tambah Materi - SekulLegend</title>

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
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            Tambah Materi Baru
          </h1>

          <p class="mt-2 text-sm text-stone-500">
            Tambahkan materi pembelajaran agar dapat diakses oleh siswa.
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

          <form action="<?= base_url('/kelas/simpanMateri') ?>" method="post" enctype="multipart/form-data" class="space-y-5">
            <?= csrf_field() ?>

            <input type="hidden" name="id_kelas" value="<?= esc($id_kelas) ?>">

            <div>
              <label for="judul" class="mb-2 block text-sm font-medium text-stone-700">
                Judul Materi <span class="text-red-500">*</span>
              </label>

              <input
                type="text"
                id="judul"
                name="judul"
                value="<?= esc(old('judul')) ?>"
                required
                placeholder="Contoh: Pengenalan Matematika Dasar"
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
                placeholder="Berikan deskripsi singkat tentang materi pembelajaran ini..."
                class="w-full rounded-lg border border-burlap-200 bg-burlap-50/50 px-4 py-3 text-sm text-stone-800 outline-none transition placeholder:text-stone-400 focus:border-burlap-500 focus:ring-2 focus:ring-burlap-200"
              ><?= esc(old('deskripsi')) ?></textarea>

              <p class="mt-2 text-xs text-burlap-600">
                Deskripsi membantu siswa memahami isi materi sebelum membuka file.
              </p>
            </div>

            <div>
              <label for="file" class="mb-2 block text-sm font-medium text-stone-700">
                Upload File Materi
              </label>

              <div class="relative rounded-xl border border-dashed border-burlap-300 bg-blue-50 p-6">
                <input
                  type="file"
                  id="file"
                  name="file"
                  class="absolute inset-0 h-full w-full cursor-pointer opacity-0"
                >

                <div class="text-center">
                  <svg class="mx-auto h-12 w-12 text-blue-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                  </svg>

                  <p class="mt-2 text-sm text-blue-700">
                    Drag and drop file atau <span class="font-semibold text-blue-600">klik untuk memilih</span>
                  </p>

                  <p class="mt-1 text-xs text-blue-500">
                    Format: PDF, DOC, DOCX, PPT, PPTX, XLS, XLSX. Maksimal 10MB.
                  </p>
                </div>

                <p id="selectedFileName" class="mt-3 text-center text-sm font-medium text-burlap-700"></p>
              </div>
            </div>

            <div class="flex flex-col gap-3 border-t border-burlap-200 pt-5 sm:flex-row sm:justify-between">
              <a
                href="<?= base_url('/kelas') ?>"
                class="inline-flex w-full items-center justify-center rounded-lg border border-red-300 px-5 py-3 text-sm font-semibold text-red-600 transition hover:bg-red-50 sm:w-auto"
              >
                Batal
              </a>

              <button
                type="submit"
                class="inline-flex w-full items-center justify-center gap-2 rounded-lg bg-green-600 px-5 py-3 text-sm font-semibold text-white shadow-md transition hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 sm:w-auto"
              >
                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                Simpan Materi
              </button>
            </div>
          </form>
        </div>
      </div>

      <p class="mt-6 text-center text-sm text-stone-500">
        Materi akan langsung tersedia untuk siswa setelah disimpan.
      </p>
    </section>
  </main>

  <script>
    const fileInput = document.getElementById('file');
    const selectedFileName = document.getElementById('selectedFileName');

    fileInput?.addEventListener('change', function (event) {
      const fileName = event.target.files[0] ? event.target.files[0].name : '';
      selectedFileName.textContent = fileName;
    });
  </script>
</body>
</html>