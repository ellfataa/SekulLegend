<?php
$nama = session()->get('nama') ?? 'Pengguna';
$kelas = isset($kelas) && is_array($kelas) ? $kelas : [];
$inisial = strtoupper(mb_substr($nama, 0, 1));
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>Daftar Kelas Guru - SekulLegend</title>

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
          <a href="<?= base_url('/guru/kelas') ?>" class="text-xl font-bold tracking-tight text-stone-800 sm:text-2xl">
            Sekul<span class="text-amber-700">Legend</span>
          </a>

          <div class="hidden items-center gap-2 md:flex">
            <a
              href="<?= base_url('/guru/kelas') ?>"
              class="rounded-lg bg-amber-50 px-4 py-2 text-sm font-semibold text-amber-700"
            >
              Kelas
            </a>

            <a
              href="<?= base_url('/kelas/tambah') ?>"
              class="rounded-lg px-4 py-2 text-sm font-medium text-stone-600 transition hover:bg-amber-50 hover:text-amber-700"
            >
              Buat Kelas
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
                href="<?= base_url('/kelas/edit-profil') ?>"
                class="block px-4 py-3 text-sm text-stone-700 transition hover:bg-amber-50 hover:text-amber-700"
              >
                Profil Saya
              </a>

              <div class="border-t border-stone-100"></div>

              <a
                href="<?= base_url('/logout') ?>"
                class="block px-4 py-3 text-sm font-medium text-red-600 transition hover:bg-red-50"
              >
                Logout
              </a>
            </div>
          </div>
        </div>

        <!-- Mobile Menu -->
        <div id="mobileMenu" class="hidden border-t border-stone-100 py-3 md:hidden">
          <div class="flex flex-col gap-2">
            <a
              href="<?= base_url('/guru/kelas') ?>"
              class="rounded-lg bg-amber-50 px-4 py-2 text-sm font-semibold text-amber-700"
            >
              Kelas
            </a>

            <a
              href="<?= base_url('/kelas/tambah') ?>"
              class="rounded-lg px-4 py-2 text-sm font-medium text-stone-600 transition hover:bg-amber-50 hover:text-amber-700"
            >
              Buat Kelas
            </a>
          </div>
        </div>
      </nav>
    </header>

    <!-- Main Content -->
    <main class="flex-1">
      <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">

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
            Daftar Kelas Guru
          </p>

          <h1 class="mt-3 text-2xl font-bold tracking-tight text-stone-800 sm:text-3xl lg:text-4xl">
            Halo, <?= esc($nama) ?>!
          </h1>

          <p class="mt-4 max-w-2xl text-sm leading-6 text-stone-600 sm:text-base">
            Kelola kelas, materi, dan diskusi pembelajaran yang Anda buat di SekulLegend.
          </p>
        </section>

        <section class="grid gap-6 lg:grid-cols-3">
          <!-- Action Menu -->
          <aside class="lg:col-span-1">
            <div class="overflow-hidden rounded-2xl border border-burlap-200 bg-white/90 shadow-md backdrop-blur-sm">
              <div class="border-b border-burlap-200 bg-burlap-50 px-6 py-4">
                <h2 class="flex items-center gap-2 text-lg font-bold text-amber-700">
                  Menu Aksi
                </h2>
              </div>

              <div class="p-6">
                <a
                  href="<?= base_url('/kelas/tambah') ?>"
                  class="inline-flex w-full items-center justify-center gap-2 rounded-lg bg-burlap-600 px-4 py-3 text-sm font-semibold text-white shadow-md transition hover:bg-burlap-700 focus:outline-none focus:ring-2 focus:ring-burlap-500 focus:ring-offset-2"
                >
                  <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v12m6-6H6" />
                  </svg>
                  Buat Kelas Baru
                </a>
              </div>
            </div>
          </aside>

          <!-- Class List -->
          <div class="lg:col-span-2">
            <div class="overflow-hidden rounded-2xl border border-burlap-200 bg-white/90 shadow-md backdrop-blur-sm">
              <div class="border-b border-burlap-200 bg-burlap-50 px-6 py-4">
                <h2 class="flex items-center gap-2 text-lg font-bold text-amber-700">
                  Daftar Kelas yang Anda Buat
                </h2>
              </div>

              <?php if (empty($kelas)) : ?>
                <div class="flex flex-col items-center justify-center px-6 py-12 text-center">
                  <div class="mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-burlap-100 text-burlap-600">
                    <svg class="h-8 w-8" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                  </div>

                  <p class="font-semibold text-stone-800">
                    Belum ada kelas yang dibuat.
                  </p>

                  <p class="mt-2 text-sm text-stone-500">
                    Klik tombol “Buat Kelas Baru” untuk mulai membuat kelas pembelajaran.
                  </p>
                </div>
              <?php else : ?>
                <div class="divide-y divide-burlap-100">
                  <?php foreach ($kelas as $k) : ?>
                    <article class="px-6 py-5 transition hover:bg-burlap-50/60">
                      <div class="flex flex-col gap-4 xl:flex-row xl:items-center xl:justify-between">
                        <div>
                          <h3 class="text-base font-bold text-stone-800 sm:text-lg">
                            <?= esc($k['nama_kelas'] ?? 'Nama kelas tidak tersedia') ?>
                          </h3>

                          <p class="mt-1 text-sm text-burlap-700">
                            Kode:
                            <span class="font-semibold">
                              <?= esc($k['kode_kelas'] ?? '-') ?>
                            </span>
                          </p>
                        </div>

                        <div class="flex flex-wrap gap-2">
                          <a
                            href="<?= base_url('/kelas/edit/' . ($k['id'] ?? 0)) ?>"
                            class="rounded-lg bg-blue-100 px-3 py-2 text-sm font-medium text-blue-700 transition hover:bg-blue-200"
                          >
                            Edit
                          </a>

                          <a
                            href="<?= base_url('/kelas/tambahMateri/' . ($k['id'] ?? 0)) ?>"
                            class="rounded-lg bg-green-100 px-3 py-2 text-sm font-medium text-green-700 transition hover:bg-green-200"
                          >
                            Tambah Materi
                          </a>

                          <a
                            href="<?= base_url('/materi/kelas/' . ($k['id'] ?? 0)) ?>"
                            class="rounded-lg bg-indigo-100 px-3 py-2 text-sm font-medium text-indigo-700 transition hover:bg-indigo-200"
                          >
                            Lihat Materi
                          </a>

                          <a
                            href="<?= base_url('/kelas/diskusi/' . ($k['id'] ?? 0)) ?>"
                            class="rounded-lg bg-purple-100 px-3 py-2 text-sm font-medium text-purple-700 transition hover:bg-purple-200"
                          >
                            Diskusi
                          </a>

                          <a
                            href="<?= base_url('/kelas/hapus/' . ($k['id'] ?? 0)) ?>"
                            class="rounded-lg bg-red-100 px-3 py-2 text-sm font-medium text-red-700 transition hover:bg-red-200"
                            onclick="return confirm('Yakin ingin menghapus kelas ini?')"
                          >
                            Hapus
                          </a>
                        </div>
                      </div>
                    </article>
                  <?php endforeach; ?>
                </div>
              <?php endif; ?>
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