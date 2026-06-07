<?php
$kelas = isset($kelas) && is_array($kelas)
  ? $kelas
  : [
      'id'         => 0,
      'nama_kelas' => '-',
    ];

$materi = isset($materi) && is_array($materi) ? $materi : [];
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>Materi Kelas - SekulLegend</title>

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
  <div class="flex min-h-screen flex-col">
    <main class="flex-1">
      <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">

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

        <!-- Header Banner -->
        <section class="mb-8 overflow-hidden rounded-2xl border border-amber-100 bg-white/90 p-6 shadow-xl backdrop-blur-sm sm:p-8">
          <p class="text-sm font-semibold uppercase tracking-wide text-amber-700">
            Materi Kelas
          </p>

          <h1 class="mt-3 text-2xl font-bold tracking-tight text-stone-800 sm:text-3xl lg:text-4xl">
            <?= esc($kelas['nama_kelas'] ?? '-') ?>
          </h1>

          <p class="mt-4 max-w-2xl text-sm leading-6 text-stone-600 sm:text-base">
            Kelola dan akses semua materi pembelajaran yang tersedia di kelas ini.
          </p>
        </section>

        <!-- Flash Message -->
        <?php if (session()->getFlashdata('success')) : ?>
          <div class="mb-6 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
            <?= esc(session()->getFlashdata('success')) ?>
          </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')) : ?>
          <div class="mb-6 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
            <?= esc(session()->getFlashdata('error')) ?>
          </div>
        <?php endif; ?>

        <!-- Daftar Materi -->
        <section class="overflow-hidden rounded-2xl border border-burlap-200 bg-white/90 shadow-md backdrop-blur-sm">
          <div class="border-b border-burlap-200 bg-burlap-50 px-6 py-4">
            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
              <h2 class="flex items-center gap-2 text-lg font-bold text-amber-700">
                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                </svg>
                Daftar Materi
              </h2>

              <a
                href="<?= base_url('/kelas/tambahMateri/' . ($kelas['id'] ?? 0)) ?>"
                class="inline-flex w-full items-center justify-center rounded-lg bg-green-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-green-700 sm:w-auto"
              >
                Tambah Materi
              </a>
            </div>
          </div>

          <div class="p-6">
            <?php if (empty($materi)) : ?>
              <div class="flex flex-col items-center justify-center py-10 text-center">
                <div class="mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-burlap-100 text-burlap-600">
                  <svg class="h-8 w-8" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                  </svg>
                </div>

                <p class="font-semibold text-stone-800">
                  Belum ada materi dalam kelas ini.
                </p>

                <p class="mt-2 text-sm text-stone-500">
                  Tambahkan materi baru agar dapat diakses oleh siswa.
                </p>
              </div>
            <?php else : ?>
              <div class="space-y-4">
                <?php foreach ($materi as $m) : ?>
                  <article class="rounded-xl border border-burlap-200 bg-white p-5 transition hover:bg-burlap-50/60">
                    <div class="flex flex-col gap-4 sm:flex-row sm:items-start">
                      <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-green-100 text-green-700">
                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                      </div>

                      <div class="min-w-0 flex-1">
                        <h3 class="text-lg font-bold text-stone-800">
                          <?= esc($m['judul'] ?? 'Materi tanpa judul') ?>
                        </h3>

                        <?php if (! empty($m['deskripsi'])) : ?>
                          <p class="mt-2 text-sm leading-6 text-stone-600">
                            <?= esc($m['deskripsi']) ?>
                          </p>
                        <?php endif; ?>

                        <div class="mt-4 flex flex-wrap gap-2">
                          <?php if (! empty($m['file'])) : ?>
                            <a
                              href="<?= base_url('uploads/materi/' . ($m['file'] ?? '')) ?>"
                              target="_blank"
                              rel="noopener noreferrer"
                              class="inline-flex items-center rounded-lg bg-burlap-600 px-3 py-2 text-sm font-medium text-white shadow-sm transition hover:bg-burlap-700"
                            >
                              Download Materi
                            </a>
                          <?php endif; ?>

                          <a
                            href="<?= base_url('/materi/edit/' . ($m['id'] ?? 0)) ?>"
                            class="inline-flex items-center rounded-lg bg-blue-600 px-3 py-2 text-sm font-medium text-white shadow-sm transition hover:bg-blue-700"
                          >
                            Edit
                          </a>

                          <a
                            href="<?= base_url('/materi/hapus/' . ($m['id'] ?? 0)) ?>"
                            onclick="return confirm('Yakin ingin menghapus materi ini?')"
                            class="inline-flex items-center rounded-lg bg-red-600 px-3 py-2 text-sm font-medium text-white shadow-sm transition hover:bg-red-700"
                          >
                            Hapus
                          </a>
                        </div>
                      </div>
                    </div>
                  </article>
                <?php endforeach; ?>
              </div>
            <?php endif; ?>
          </div>
        </section>
      </div>
    </main>

    <footer class="mt-10 border-t border-stone-200 bg-white/90">
      <div class="mx-auto flex max-w-7xl flex-col items-center justify-between gap-3 px-4 py-6 sm:px-6 md:flex-row lg:px-8">
        <h2 class="text-lg font-bold text-stone-800">
          Sekul<span class="text-amber-700">Legend</span>
        </h2>

        <p class="text-center text-sm text-stone-500 md:text-right">
          &copy; 2023 SekulLegend. All rights reserved.
        </p>
      </div>
    </footer>
  </div>
</body>
</html>