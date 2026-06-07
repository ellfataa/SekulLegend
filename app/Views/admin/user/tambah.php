<?php
$nama = session()->get('nama') ?? 'Admin';
$inisial = strtoupper(mb_substr($nama, 0, 1));
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>Tambah User - SekulLegend</title>

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
              class="rounded-lg px-4 py-2 text-sm font-medium text-stone-600 transition hover:bg-amber-50 hover:text-amber-700"
            >
              Dashboard
            </a>

            <a
              href="<?= base_url('admin/user') ?>"
              class="rounded-lg bg-amber-50 px-4 py-2 text-sm font-semibold text-amber-700"
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
              class="rounded-lg px-4 py-2 text-sm font-medium text-stone-600 transition hover:bg-amber-50 hover:text-amber-700"
            >
              Dashboard
            </a>

            <a
              href="<?= base_url('admin/user') ?>"
              class="rounded-lg bg-amber-50 px-4 py-2 text-sm font-semibold text-amber-700"
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

        <!-- Back Button -->
        <div class="mb-5">
          <a
            href="<?= base_url('admin/user') ?>"
            class="inline-flex items-center gap-2 text-sm font-medium text-burlap-700 transition hover:text-burlap-900"
          >
            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Kembali ke Manajemen User
          </a>
        </div>

        <!-- Header Banner -->
        <section class="mb-8 overflow-hidden rounded-2xl border border-amber-100 bg-white/90 p-6 shadow-xl backdrop-blur-sm sm:p-8">
          <p class="text-sm font-semibold uppercase tracking-wide text-amber-700">
            Admin Area
          </p>

          <h1 class="mt-3 text-2xl font-bold tracking-tight text-stone-800 sm:text-3xl lg:text-4xl">
            Tambah User
          </h1>

          <p class="mt-4 max-w-2xl text-sm leading-6 text-stone-600 sm:text-base">
            Tambahkan pengguna baru sebagai guru atau siswa pada platform SekulLegend.
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

        <!-- Form Card -->
        <section class="mx-auto max-w-3xl">
          <div class="overflow-hidden rounded-2xl border border-burlap-200 bg-white/90 shadow-md backdrop-blur-sm">
            <div class="border-b border-burlap-200 bg-burlap-50 px-6 py-4">
              <h2 class="flex items-center gap-2 text-lg font-bold text-amber-700">
                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                </svg>
                Form Tambah User
              </h2>

              <p class="mt-1 text-sm text-stone-500">
                Lengkapi data user dengan benar.
              </p>
            </div>

            <div class="p-6">
              <form action="<?= base_url('admin/user/simpan') ?>" method="post" class="space-y-5">
                <?= csrf_field() ?>

                <div class="grid gap-5 md:grid-cols-2">
                  <div>
                    <label for="nama" class="mb-2 block text-sm font-medium text-stone-700">
                      Nama Lengkap
                    </label>

                    <input
                      type="text"
                      name="nama"
                      id="nama"
                      value="<?= esc(old('nama')) ?>"
                      placeholder="Masukkan nama lengkap"
                      required
                      autocomplete="name"
                      class="w-full rounded-lg border border-burlap-200 bg-burlap-50/50 px-4 py-3 text-sm text-stone-800 outline-none transition placeholder:text-stone-400 focus:border-amber-500 focus:ring-2 focus:ring-amber-200"
                    >
                  </div>

                  <div>
                    <label for="username" class="mb-2 block text-sm font-medium text-stone-700">
                      Username
                    </label>

                    <input
                      type="text"
                      name="username"
                      id="username"
                      value="<?= esc(old('username')) ?>"
                      placeholder="Masukkan username"
                      required
                      autocomplete="username"
                      class="w-full rounded-lg border border-burlap-200 bg-burlap-50/50 px-4 py-3 text-sm text-stone-800 outline-none transition placeholder:text-stone-400 focus:border-amber-500 focus:ring-2 focus:ring-amber-200"
                    >
                  </div>
                </div>

                <div>
                  <label for="password" class="mb-2 block text-sm font-medium text-stone-700">
                    Password
                  </label>

                  <input
                    type="password"
                    name="password"
                    id="password"
                    placeholder="Masukkan password"
                    required
                    autocomplete="new-password"
                    class="w-full rounded-lg border border-burlap-200 bg-burlap-50/50 px-4 py-3 text-sm text-stone-800 outline-none transition placeholder:text-stone-400 focus:border-amber-500 focus:ring-2 focus:ring-amber-200"
                  >

                  <p class="mt-2 text-xs text-burlap-600">
                    Minimal 6 karakter.
                  </p>
                </div>

                <div>
                  <label for="role" class="mb-2 block text-sm font-medium text-stone-700">
                    Role
                  </label>

                  <select
                    name="role"
                    id="role"
                    required
                    class="w-full rounded-lg border border-burlap-200 bg-burlap-50/50 px-4 py-3 text-sm text-stone-800 outline-none transition focus:border-amber-500 focus:ring-2 focus:ring-amber-200"
                  >
                    <option value="" disabled <?= old('role') ? '' : 'selected' ?>>
                      Pilih role user
                    </option>
                    <option value="guru" <?= old('role') === 'guru' ? 'selected' : '' ?>>
                      Guru
                    </option>
                    <option value="siswa" <?= old('role') === 'siswa' ? 'selected' : '' ?>>
                      Siswa
                    </option>
                  </select>
                </div>

                <div class="flex flex-col gap-3 border-t border-burlap-200 pt-5 sm:flex-row sm:justify-end">
                  <a
                    href="<?= base_url('admin/user') ?>"
                    class="inline-flex w-full items-center justify-center rounded-lg border border-stone-300 px-5 py-3 text-sm font-semibold text-stone-700 transition hover:bg-stone-100 sm:w-auto"
                  >
                    Batal
                  </a>

                  <button
                    type="submit"
                    class="inline-flex w-full items-center justify-center gap-2 rounded-lg bg-amber-600 px-5 py-3 text-sm font-semibold text-white shadow-md transition hover:bg-amber-700 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2 sm:w-auto"
                  >
                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    Simpan User
                  </button>
                </div>
              </form>
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