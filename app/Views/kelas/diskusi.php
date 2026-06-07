<?php
$nama = session()->get('nama') ?? 'Pengguna';
$idUser = session()->get('id');

$kelas = isset($kelas) && is_array($kelas)
  ? $kelas
  : [
      'id'         => $id_kelas ?? 0,
      'nama_kelas' => '-',
    ];

$id_kelas = $id_kelas ?? ($kelas['id'] ?? 0);
$diskusi = isset($diskusi) && is_array($diskusi) ? $diskusi : [];
$userMap = isset($userMap) && is_array($userMap) ? $userMap : [];
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>Diskusi Kelas - SekulLegend</title>

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
            Forum Diskusi
          </p>

          <h1 class="mt-3 text-2xl font-bold tracking-tight text-stone-800 sm:text-3xl lg:text-4xl">
            Diskusi: <?= esc($kelas['nama_kelas'] ?? '-') ?>
          </h1>

          <p class="mt-4 max-w-2xl text-sm leading-6 text-stone-600 sm:text-base">
            Diskusikan materi pembelajaran bersama guru dan siswa di kelas ini.
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

        <!-- Form Kirim Pesan -->
        <section class="mb-6 overflow-hidden rounded-2xl border border-burlap-200 bg-white/90 shadow-md backdrop-blur-sm">
          <div class="border-b border-burlap-200 bg-burlap-50 px-6 py-4">
            <h2 class="flex items-center gap-2 text-lg font-bold text-amber-700">
              <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
              </svg>
              Kirim Pesan
            </h2>
          </div>

          <div class="p-6">
            <form action="<?= base_url('/kelas/diskusi/' . $id_kelas . '/kirim') ?>" method="post" class="space-y-4">
              <?= csrf_field() ?>

              <div>
                <label for="pesan" class="mb-2 block text-sm font-medium text-stone-700">
                  Pesan Diskusi
                </label>

                <textarea
                  name="pesan"
                  id="pesan"
                  rows="4"
                  required
                  placeholder="Tulis pesan diskusi Anda di sini..."
                  class="w-full rounded-lg border border-burlap-200 bg-burlap-50/50 px-4 py-3 text-sm text-stone-800 outline-none transition placeholder:text-stone-400 focus:border-burlap-500 focus:ring-2 focus:ring-burlap-200"
                ><?= esc(old('pesan')) ?></textarea>
              </div>

              <button
                type="submit"
                class="inline-flex w-full items-center justify-center gap-2 rounded-lg bg-green-600 px-5 py-3 text-sm font-semibold text-white shadow-md transition hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 sm:w-auto"
              >
                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                </svg>
                Kirim Pesan
              </button>
            </form>
          </div>
        </section>

        <!-- Daftar Diskusi -->
        <section class="space-y-4">
          <?php if (empty($diskusi)) : ?>
            <div class="rounded-2xl border border-burlap-200 bg-white/90 px-6 py-12 text-center shadow-md backdrop-blur-sm">
              <div class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-burlap-100 text-burlap-600">
                <svg class="h-8 w-8" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                </svg>
              </div>

              <p class="font-semibold text-stone-800">
                Belum ada diskusi di kelas ini.
              </p>

              <p class="mt-2 text-sm text-burlap-600">
                Mulailah percakapan dengan mengirim pesan pertama.
              </p>
            </div>
          <?php else : ?>
            <?php foreach ($diskusi as $d) : ?>
              <?php
                $namaPengirim = $userMap[$d['id_user']] ?? 'Pengguna';
                $inisialPengirim = strtoupper(mb_substr($namaPengirim, 0, 1));
                $isOwnComment = (int) $idUser === (int) ($d['id_user'] ?? 0);
              ?>

              <article class="overflow-hidden rounded-2xl border border-burlap-200 bg-white/90 shadow-md backdrop-blur-sm">
                <div class="border-b border-burlap-200 bg-burlap-50 px-6 py-4">
                  <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
                    <div class="flex items-center gap-3">
                      <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-amber-100 text-sm font-bold text-amber-700">
                        <?= esc($inisialPengirim) ?>
                      </div>

                      <div>
                        <h3 class="text-sm font-semibold text-stone-800">
                          <?= esc($namaPengirim) ?>
                        </h3>

                        <p class="text-xs text-burlap-600">
                          <?= ! empty($d['created_at']) ? esc(date('d M Y H:i', strtotime($d['created_at']))) : '-' ?>
                        </p>
                      </div>
                    </div>

                    <?php if ($isOwnComment) : ?>
                      <div class="flex items-center gap-3">
                        <a
                          href="<?= base_url('/kelas/edit-diskusi/' . ($d['id'] ?? 0)) ?>"
                          class="text-sm font-medium text-blue-600 hover:text-blue-800 hover:underline"
                        >
                          Edit
                        </a>

                        <a
                          href="<?= base_url('/kelas/hapus-diskusi/' . ($d['id'] ?? 0) . '/' . $id_kelas) ?>"
                          onclick="return confirm('Yakin ingin menghapus komentar ini?')"
                          class="text-sm font-medium text-red-600 hover:text-red-800 hover:underline"
                        >
                          Hapus
                        </a>
                      </div>
                    <?php endif; ?>
                  </div>
                </div>

                <div class="p-6">
                  <p class="text-sm leading-6 text-stone-700">
                    <?= nl2br(esc($d['pesan'] ?? '')) ?>
                  </p>
                </div>
              </article>
            <?php endforeach; ?>
          <?php endif; ?>
        </section>
      </div>
    </main>

    <!-- Footer -->
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