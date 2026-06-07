<?php
$nama = session()->get('nama') ?? 'Pengguna';
$idUser = session()->get('id');

$kelas = isset($kelas) && is_array($kelas) ? $kelas : ['id' => 0, 'nama_kelas' => '-'];
$materi = isset($materi) && is_array($materi) ? $materi : [];
$diskusi = isset($diskusi) && is_array($diskusi) ? $diskusi : [];
$userMap = isset($userMap) && is_array($userMap) ? $userMap : [];

$inisial = strtoupper(mb_substr($nama, 0, 1));
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>Detail Kelas - SekulLegend</title>

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

    <!-- Navbar -->
    <header class="sticky top-0 z-40 border-b border-stone-200 bg-white/90 shadow-sm backdrop-blur">
      <nav class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 items-center justify-between">
          <a href="<?= base_url('siswa/dashboard') ?>" class="text-xl font-bold tracking-tight text-stone-800 sm:text-2xl">
            Sekul<span class="text-amber-700">Legend</span>
          </a>

          <div class="hidden items-center gap-2 md:flex">
            <a
              href="<?= base_url('siswa/dashboard') ?>"
              class="rounded-lg px-4 py-2 text-sm font-medium text-stone-600 transition hover:bg-amber-50 hover:text-amber-700"
            >
              Dashboard
            </a>

            <a
              href="<?= base_url('siswa/kelas') ?>"
              class="rounded-lg bg-amber-50 px-4 py-2 text-sm font-semibold text-amber-700"
            >
              Kelas
            </a>
          </div>

          <div class="relative flex items-center gap-2">
            <button
              type="button"
              id="mobileMenuButton"
              class="inline-flex h-10 w-10 items-center justify-center rounded-lg text-stone-600 transition hover:bg-amber-50 hover:text-amber-700 md:hidden"
              aria-label="Buka menu navigasi"
              aria-expanded="false"
            >
              <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7h16M4 12h16M4 17h16" />
              </svg>
            </button>

            <button
              type="button"
              id="userMenuButton"
              class="flex items-center gap-2 rounded-lg px-2 py-1.5 transition hover:bg-amber-50"
              aria-label="Buka menu pengguna"
              aria-expanded="false"
            >
              <span class="flex h-9 w-9 items-center justify-center rounded-full bg-amber-100 text-sm font-bold text-amber-700">
                <?= esc($inisial) ?>
              </span>

              <span class="hidden max-w-40 truncate text-sm font-medium text-stone-700 sm:inline">
                <?= esc($nama) ?>
              </span>

              <svg class="h-5 w-5 text-stone-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path d="M19 9l-7 7-7-7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
              </svg>
            </button>

            <div
              id="userDropdown"
              class="absolute right-0 top-12 hidden w-48 overflow-hidden rounded-xl border border-stone-100 bg-white shadow-lg"
            >
              <a
                href="<?= base_url('/siswa/edit-profil') ?>"
                class="block px-4 py-3 text-sm text-stone-700 transition hover:bg-amber-50 hover:text-amber-700"
              >
                Profil Saya
              </a>

              <div class="border-t border-stone-100"></div>

              <a
                href="<?= base_url('logout') ?>"
                class="block px-4 py-3 text-sm font-medium text-red-600 transition hover:bg-red-50"
              >
                Logout
              </a>
            </div>
          </div>
        </div>

        <div id="mobileMenu" class="hidden border-t border-stone-100 py-3 md:hidden">
          <div class="flex flex-col gap-2">
            <a
              href="<?= base_url('siswa/dashboard') ?>"
              class="rounded-lg px-4 py-2 text-sm font-medium text-stone-600 transition hover:bg-amber-50 hover:text-amber-700"
            >
              Dashboard
            </a>

            <a
              href="<?= base_url('siswa/kelas') ?>"
              class="rounded-lg bg-amber-50 px-4 py-2 text-sm font-semibold text-amber-700"
            >
              Kelas
            </a>
          </div>
        </div>
      </nav>
    </header>

    <!-- Main Content -->
    <main class="flex-1">
      <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">

        <!-- Back Button -->
        <div class="mb-5">
          <a
            href="<?= base_url('/siswa/kelas') ?>"
            class="inline-flex items-center gap-2 text-sm font-medium text-burlap-700 transition hover:text-burlap-900"
          >
            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Kembali ke Daftar Kelas
          </a>
        </div>

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

        <!-- Header Banner -->
        <section class="mb-8 overflow-hidden rounded-2xl border border-amber-100 bg-white/90 p-6 shadow-xl backdrop-blur-sm sm:p-8">
          <p class="text-sm font-semibold uppercase tracking-wide text-amber-700">
            Detail Kelas
          </p>

          <h1 class="mt-3 text-2xl font-bold tracking-tight text-stone-800 sm:text-3xl lg:text-4xl">
            <?= esc($kelas['nama_kelas'] ?? '-') ?>
          </h1>

          <p class="mt-4 max-w-2xl text-sm leading-6 text-stone-600 sm:text-base">
            Akses materi pembelajaran dan ikuti forum diskusi pada kelas ini.
          </p>
        </section>

        <section class="grid gap-6 lg:grid-cols-3">
          <!-- Materi -->
          <aside class="lg:col-span-1">
            <div class="overflow-hidden rounded-2xl border border-burlap-200 bg-white/90 shadow-md backdrop-blur-sm">
              <div class="border-b border-burlap-200 bg-burlap-50 px-6 py-4">
                <h2 class="flex items-center gap-2 text-lg font-bold text-amber-700">
                  <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                  </svg>
                  Materi Pembelajaran
                </h2>
              </div>

              <div class="p-6">
                <?php if (empty($materi)) : ?>
                  <div class="flex flex-col items-center justify-center py-8 text-center">
                    <div class="mb-4 flex h-14 w-14 items-center justify-center rounded-full bg-burlap-100 text-burlap-500">
                      <svg class="h-7 w-7" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                      </svg>
                    </div>

                    <p class="text-sm text-burlap-600">
                      Belum ada materi pembelajaran.
                    </p>
                  </div>
                <?php else : ?>
                  <ul class="space-y-3">
                    <?php foreach ($materi as $m) : ?>
                      <li class="rounded-xl border border-burlap-100 bg-burlap-50/50 p-4 transition hover:bg-burlap-50">
                        <div class="flex items-start gap-3">
                          <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-blue-100 text-blue-700">
                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                          </div>

                          <div class="min-w-0">
                            <a
                              href="<?= base_url('public/uploads/materi/' . ($m['file'] ?? '')) ?>"
                              class="break-words text-sm font-semibold text-blue-600 hover:text-blue-800 hover:underline"
                              target="_blank"
                              rel="noopener noreferrer"
                            >
                              <?= esc($m['judul'] ?? 'Materi tanpa judul') ?>
                            </a>
                          </div>
                        </div>
                      </li>
                    <?php endforeach; ?>
                  </ul>
                <?php endif; ?>
              </div>
            </div>
          </aside>

          <!-- Diskusi -->
          <div class="lg:col-span-2">
            <div class="overflow-hidden rounded-2xl border border-burlap-200 bg-white/90 shadow-md backdrop-blur-sm">
              <div class="border-b border-burlap-200 bg-burlap-50 px-6 py-4">
                <h2 class="flex items-center gap-2 text-lg font-bold text-amber-700">
                  <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                  </svg>
                  Forum Diskusi
                </h2>
              </div>

              <div class="p-6">
                <!-- Form Komentar -->
                <form action="<?= base_url('/siswa/kelas/' . ($kelas['id'] ?? 0) . '/kirim') ?>" method="post" class="mb-6 space-y-4">
                  <?= csrf_field() ?>

                  <div>
                    <label for="pesan" class="mb-2 block text-sm font-medium text-stone-700">
                      Tulis Komentar
                    </label>

                    <textarea
                      name="pesan"
                      id="pesan"
                      rows="4"
                      required
                      placeholder="Tulis pesan diskusi..."
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

                <!-- Daftar Komentar -->
                <div class="space-y-4">
                  <?php if (empty($diskusi)) : ?>
                    <div class="flex flex-col items-center justify-center rounded-xl bg-burlap-50/60 px-6 py-10 text-center">
                      <div class="mb-4 flex h-14 w-14 items-center justify-center rounded-full bg-burlap-100 text-burlap-500">
                        <svg class="h-7 w-7" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                        </svg>
                      </div>

                      <p class="text-sm text-burlap-600">
                        Belum ada diskusi. Mulai diskusi dengan mengirim pesan.
                      </p>
                    </div>
                  <?php else : ?>
                    <?php foreach ($diskusi as $d) : ?>
                      <?php
                        $namaDiskusi = $userMap[$d['id_user']] ?? 'Pengguna';
                        $inisialDiskusi = strtoupper(mb_substr($namaDiskusi, 0, 1));
                        $isOwnComment = (int) $idUser === (int) ($d['id_user'] ?? 0);
                      ?>

                      <article class="rounded-xl border border-burlap-100 p-4 shadow-sm <?= $isOwnComment ? 'bg-amber-50' : 'bg-burlap-50/60' ?>">
                        <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
                          <div class="flex items-center gap-3">
                            <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-amber-100 text-sm font-bold text-amber-700">
                              <?= esc($inisialDiskusi) ?>
                            </div>

                            <div>
                              <p class="text-sm font-semibold text-stone-800">
                                <?= esc($namaDiskusi) ?>
                              </p>

                              <p class="text-xs text-stone-500">
                                <?= ! empty($d['created_at']) ? esc(date('d M Y H:i', strtotime($d['created_at']))) : '-' ?>
                              </p>
                            </div>
                          </div>

                          <?php if ($isOwnComment) : ?>
                            <div class="flex items-center gap-3 sm:justify-end">
                              <a
                                href="<?= base_url('/siswa/edit-diskusi/' . ($d['id'] ?? 0)) ?>"
                                class="inline-flex items-center gap-1 text-sm font-medium text-blue-600 hover:text-blue-800 hover:underline"
                              >
                                Edit
                              </a>

                              <a
                                href="<?= base_url('/siswa/hapus-diskusi/' . ($kelas['id'] ?? 0) . '/' . ($d['id'] ?? 0)) ?>"
                                class="inline-flex items-center gap-1 text-sm font-medium text-red-600 hover:text-red-800 hover:underline"
                                onclick="return confirm('Yakin ingin menghapus komentar ini?')"
                              >
                                Hapus
                              </a>
                            </div>
                          <?php endif; ?>
                        </div>

                        <div class="mt-4 text-sm leading-6 text-stone-700">
                          <?= nl2br(esc($d['pesan'] ?? '')) ?>
                        </div>
                      </article>
                    <?php endforeach; ?>
                  <?php endif; ?>
                </div>
              </div>
            </div>
          </div>
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

  <script>
    const userMenuButton = document.getElementById('userMenuButton');
    const userDropdown = document.getElementById('userDropdown');
    const mobileMenuButton = document.getElementById('mobileMenuButton');
    const mobileMenu = document.getElementById('mobileMenu');

    function closeUserDropdown() {
      userDropdown?.classList.add('hidden');
      userMenuButton?.setAttribute('aria-expanded', 'false');
    }

    function closeMobileMenu() {
      mobileMenu?.classList.add('hidden');
      mobileMenuButton?.setAttribute('aria-expanded', 'false');
    }

    userMenuButton?.addEventListener('click', function (event) {
      event.stopPropagation();

      const isHidden = userDropdown.classList.toggle('hidden');
      userMenuButton.setAttribute('aria-expanded', String(!isHidden));

      closeMobileMenu();
    });

    mobileMenuButton?.addEventListener('click', function (event) {
      event.stopPropagation();

      const isHidden = mobileMenu.classList.toggle('hidden');
      mobileMenuButton.setAttribute('aria-expanded', String(!isHidden));

      closeUserDropdown();
    });

    document.addEventListener('click', function (event) {
      const clickedOutsideUserMenu =
        userDropdown &&
        userMenuButton &&
        !userDropdown.contains(event.target) &&
        !userMenuButton.contains(event.target);

      const clickedOutsideMobileMenu =
        mobileMenu &&
        mobileMenuButton &&
        !mobileMenu.contains(event.target) &&
        !mobileMenuButton.contains(event.target);

      if (clickedOutsideUserMenu) {
        closeUserDropdown();
      }

      if (clickedOutsideMobileMenu) {
        closeMobileMenu();
      }
    });

    document.addEventListener('keydown', function (event) {
      if (event.key === 'Escape') {
        closeUserDropdown();
        closeMobileMenu();
      }
    });
  </script>
</body>
</html>