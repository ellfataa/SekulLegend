<?php
$nama = session()->get('nama') ?? 'Admin';

$total_siswa   = isset($total_siswa) ? (int) $total_siswa : 0;
$total_guru    = isset($total_guru) ? (int) $total_guru : 0;
$total_kelas   = isset($total_kelas) ? (int) $total_kelas : 0;
$total_materi  = isset($total_materi) ? (int) $total_materi : 0;
$total_diskusi = isset($total_diskusi) ? (int) $total_diskusi : 0;

$inisial = strtoupper(mb_substr($nama, 0, 1));
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>Dashboard Admin - SekulLegend</title>

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

          <!-- Brand -->
          <a href="<?= base_url('admin/dashboard') ?>" class="text-xl font-bold tracking-tight text-stone-800 sm:text-2xl">
            Sekul<span class="text-amber-700">Legend</span>
          </a>

          <!-- Desktop Menu -->
          <div class="hidden items-center gap-2 lg:flex">
            <a
              href="<?= base_url('admin/dashboard') ?>"
              class="rounded-lg bg-amber-50 px-4 py-2 text-sm font-semibold text-amber-700"
            >
              Dashboard
            </a>

            <a
              href="<?= base_url('admin/user') ?>"
              class="rounded-lg px-4 py-2 text-sm font-medium text-stone-600 transition hover:bg-amber-50 hover:text-amber-700"
            >
              User
            </a>

            <a
              href="<?= base_url('admin/kelas') ?>"
              class="rounded-lg px-4 py-2 text-sm font-medium text-stone-600 transition hover:bg-amber-50 hover:text-amber-700"
            >
              Kelas
            </a>

            <a
              href="<?= base_url('admin/materi') ?>"
              class="rounded-lg px-4 py-2 text-sm font-medium text-stone-600 transition hover:bg-amber-50 hover:text-amber-700"
            >
              Materi
            </a>

            <a
              href="<?= base_url('admin/diskusi') ?>"
              class="rounded-lg px-4 py-2 text-sm font-medium text-stone-600 transition hover:bg-amber-50 hover:text-amber-700"
            >
              Diskusi
            </a>
          </div>

          <!-- Menu Buttons -->
          <div class="relative flex items-center gap-2">
            <button
              type="button"
              id="mobileMenuButton"
              class="inline-flex h-10 w-10 items-center justify-center rounded-lg text-stone-600 transition hover:bg-amber-50 hover:text-amber-700 lg:hidden"
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

            <!-- User Dropdown -->
            <div
              id="userDropdown"
              class="absolute right-0 top-12 hidden w-48 overflow-hidden rounded-xl border border-stone-100 bg-white shadow-lg"
            >
              <a
                href="<?= base_url('logout') ?>"
                class="block px-4 py-3 text-sm font-medium text-red-600 transition hover:bg-red-50"
              >
                Logout
              </a>
            </div>
          </div>
        </div>

        <!-- Mobile Menu -->
        <div id="mobileMenu" class="hidden border-t border-stone-100 py-3 lg:hidden">
          <div class="flex flex-col gap-2">
            <a
              href="<?= base_url('admin/dashboard') ?>"
              class="rounded-lg bg-amber-50 px-4 py-2 text-sm font-semibold text-amber-700"
            >
              Dashboard
            </a>

            <a
              href="<?= base_url('admin/user') ?>"
              class="rounded-lg px-4 py-2 text-sm font-medium text-stone-600 transition hover:bg-amber-50 hover:text-amber-700"
            >
              User
            </a>

            <a
              href="<?= base_url('admin/kelas') ?>"
              class="rounded-lg px-4 py-2 text-sm font-medium text-stone-600 transition hover:bg-amber-50 hover:text-amber-700"
            >
              Kelas
            </a>

            <a
              href="<?= base_url('admin/materi') ?>"
              class="rounded-lg px-4 py-2 text-sm font-medium text-stone-600 transition hover:bg-amber-50 hover:text-amber-700"
            >
              Materi
            </a>

            <a
              href="<?= base_url('admin/diskusi') ?>"
              class="rounded-lg px-4 py-2 text-sm font-medium text-stone-600 transition hover:bg-amber-50 hover:text-amber-700"
            >
              Diskusi
            </a>
          </div>
        </div>
      </nav>
    </header>

    <!-- Main Content -->
    <main class="flex-1">
      <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">

        <!-- Header Banner -->
        <section class="mb-8 overflow-hidden rounded-2xl border border-amber-100 bg-white/90 p-6 shadow-xl backdrop-blur-sm sm:p-8">
          <p class="text-sm font-semibold uppercase tracking-wide text-amber-700">
            Admin Area
          </p>

          <h1 class="mt-3 text-2xl font-bold tracking-tight text-stone-800 sm:text-3xl lg:text-4xl">
            Dashboard Admin
          </h1>

          <p class="mt-4 max-w-2xl text-sm leading-6 text-stone-600 sm:text-base">
            Kelola seluruh data pengguna, kelas, materi, dan aktivitas diskusi pada platform SekulLegend.
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

        <!-- Statistik -->
        <section class="mb-8 grid grid-cols-1 gap-5 sm:grid-cols-2 xl:grid-cols-5">
          <article class="rounded-2xl border border-green-100 bg-white/90 p-6 shadow-md backdrop-blur-sm transition hover:-translate-y-0.5 hover:shadow-lg">
            <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-xl bg-green-100 text-green-700">
              <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
              </svg>
            </div>

            <p class="text-sm font-medium text-stone-500">
              Total Siswa
            </p>

            <p class="mt-2 text-3xl font-bold text-green-700">
              <?= esc($total_siswa) ?>
            </p>
          </article>

          <article class="rounded-2xl border border-blue-100 bg-white/90 p-6 shadow-md backdrop-blur-sm transition hover:-translate-y-0.5 hover:shadow-lg">
            <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-xl bg-blue-100 text-blue-700">
              <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
              </svg>
            </div>

            <p class="text-sm font-medium text-stone-500">
              Total Guru
            </p>

            <p class="mt-2 text-3xl font-bold text-blue-700">
              <?= esc($total_guru) ?>
            </p>
          </article>

          <article class="rounded-2xl border border-purple-100 bg-white/90 p-6 shadow-md backdrop-blur-sm transition hover:-translate-y-0.5 hover:shadow-lg">
            <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-xl bg-purple-100 text-purple-700">
              <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
              </svg>
            </div>

            <p class="text-sm font-medium text-stone-500">
              Total Kelas
            </p>

            <p class="mt-2 text-3xl font-bold text-purple-700">
              <?= esc($total_kelas) ?>
            </p>
          </article>

          <article class="rounded-2xl border border-indigo-100 bg-white/90 p-6 shadow-md backdrop-blur-sm transition hover:-translate-y-0.5 hover:shadow-lg">
            <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-xl bg-indigo-100 text-indigo-700">
              <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
              </svg>
            </div>

            <p class="text-sm font-medium text-stone-500">
              Total Materi
            </p>

            <p class="mt-2 text-3xl font-bold text-indigo-700">
              <?= esc($total_materi) ?>
            </p>
          </article>

          <article class="rounded-2xl border border-pink-100 bg-white/90 p-6 shadow-md backdrop-blur-sm transition hover:-translate-y-0.5 hover:shadow-lg">
            <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-xl bg-pink-100 text-pink-700">
              <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
              </svg>
            </div>

            <p class="text-sm font-medium text-stone-500">
              Total Diskusi
            </p>

            <p class="mt-2 text-3xl font-bold text-pink-700">
              <?= esc($total_diskusi) ?>
            </p>
          </article>
        </section>

        <!-- Manajemen Data -->
        <section class="overflow-hidden rounded-2xl border border-burlap-200 bg-white/90 shadow-md backdrop-blur-sm">
          <div class="border-b border-burlap-200 bg-burlap-50 px-6 py-4">
            <h2 class="text-lg font-bold text-amber-700">
              Manajemen Data
            </h2>

            <p class="mt-1 text-sm text-stone-500">
              Akses cepat untuk mengelola data utama aplikasi.
            </p>
          </div>

          <div class="p-6">
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
              <a
                href="<?= base_url('admin/user') ?>"
                class="group rounded-xl border border-burlap-200 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:bg-burlap-50/60 hover:shadow-md"
              >
                <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-xl bg-blue-100 text-blue-700 transition group-hover:bg-blue-200">
                  <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                  </svg>
                </div>

                <h3 class="text-base font-bold text-stone-800">
                  Kelola User
                </h3>

                <p class="mt-2 text-sm leading-6 text-stone-500">
                  Tambah, ubah, dan hapus data guru maupun siswa.
                </p>
              </a>

              <a
                href="<?= base_url('admin/kelas') ?>"
                class="group rounded-xl border border-burlap-200 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:bg-burlap-50/60 hover:shadow-md"
              >
                <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-xl bg-green-100 text-green-700 transition group-hover:bg-green-200">
                  <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                  </svg>
                </div>

                <h3 class="text-base font-bold text-stone-800">
                  Kelola Kelas
                </h3>

                <p class="mt-2 text-sm leading-6 text-stone-500">
                  Atur data kelas, kode kelas, dan guru pengajar.
                </p>
              </a>

              <a
                href="<?= base_url('admin/materi') ?>"
                class="group rounded-xl border border-burlap-200 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:bg-burlap-50/60 hover:shadow-md"
              >
                <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-xl bg-indigo-100 text-indigo-700 transition group-hover:bg-indigo-200">
                  <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                  </svg>
                </div>

                <h3 class="text-base font-bold text-stone-800">
                  Kelola Materi
                </h3>

                <p class="mt-2 text-sm leading-6 text-stone-500">
                  Kelola materi pembelajaran dan file pendukung.
                </p>
              </a>

              <a
                href="<?= base_url('admin/diskusi') ?>"
                class="group rounded-xl border border-burlap-200 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:bg-burlap-50/60 hover:shadow-md"
              >
                <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-xl bg-pink-100 text-pink-700 transition group-hover:bg-pink-200">
                  <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                  </svg>
                </div>

                <h3 class="text-base font-bold text-stone-800">
                  Lihat Diskusi
                </h3>

                <p class="mt-2 text-sm leading-6 text-stone-500">
                  Pantau dan kelola komentar diskusi antar pengguna.
                </p>
              </a>
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