<?php
$nama = session()->get('nama') ?? 'Admin';

$kelas = isset($kelas) && is_array($kelas)
  ? $kelas
  : [
      'id'         => '',
      'nama_kelas' => '-',
    ];

$komentar = isset($komentar) && is_array($komentar) ? $komentar : [];
$inisial = strtoupper(mb_substr($nama, 0, 1));
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>Detail Diskusi Kelas - SekulLegend</title>

  <script src="https://cdn.tailwindcss.com"></script>

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
          <a href="<?= base_url('admin/dashboard') ?>" class="text-xl font-bold tracking-tight text-stone-800 sm:text-2xl">
            Sekul<span class="text-amber-700">Legend</span>
          </a>

          <div class="hidden items-center gap-2 lg:flex">
            <a href="<?= base_url('admin/dashboard') ?>" class="rounded-lg px-4 py-2 text-sm font-medium text-stone-600 transition hover:bg-amber-50 hover:text-amber-700">
              Dashboard
            </a>

            <a href="<?= base_url('admin/user') ?>" class="rounded-lg px-4 py-2 text-sm font-medium text-stone-600 transition hover:bg-amber-50 hover:text-amber-700">
              User
            </a>

            <a href="<?= base_url('admin/kelas') ?>" class="rounded-lg px-4 py-2 text-sm font-medium text-stone-600 transition hover:bg-amber-50 hover:text-amber-700">
              Kelas
            </a>

            <a href="<?= base_url('admin/materi') ?>" class="rounded-lg px-4 py-2 text-sm font-medium text-stone-600 transition hover:bg-amber-50 hover:text-amber-700">
              Materi
            </a>

            <a href="<?= base_url('admin/diskusi') ?>" class="rounded-lg bg-amber-50 px-4 py-2 text-sm font-semibold text-amber-700">
              Diskusi
            </a>
          </div>

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

            <div
              id="userDropdown"
              class="absolute right-0 top-12 hidden w-48 overflow-hidden rounded-xl border border-stone-100 bg-white shadow-lg"
            >
              <a href="<?= base_url('logout') ?>" class="block px-4 py-3 text-sm font-medium text-red-600 transition hover:bg-red-50">
                Logout
              </a>
            </div>
          </div>
        </div>

        <!-- Mobile Menu -->
        <div id="mobileMenu" class="hidden border-t border-stone-100 py-3 lg:hidden">
          <div class="flex flex-col gap-2">
            <a href="<?= base_url('admin/dashboard') ?>" class="rounded-lg px-4 py-2 text-sm font-medium text-stone-600 transition hover:bg-amber-50 hover:text-amber-700">
              Dashboard
            </a>

            <a href="<?= base_url('admin/user') ?>" class="rounded-lg px-4 py-2 text-sm font-medium text-stone-600 transition hover:bg-amber-50 hover:text-amber-700">
              User
            </a>

            <a href="<?= base_url('admin/kelas') ?>" class="rounded-lg px-4 py-2 text-sm font-medium text-stone-600 transition hover:bg-amber-50 hover:text-amber-700">
              Kelas
            </a>

            <a href="<?= base_url('admin/materi') ?>" class="rounded-lg px-4 py-2 text-sm font-medium text-stone-600 transition hover:bg-amber-50 hover:text-amber-700">
              Materi
            </a>

            <a href="<?= base_url('admin/diskusi') ?>" class="rounded-lg bg-amber-50 px-4 py-2 text-sm font-semibold text-amber-700">
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
          <a href="<?= base_url('admin/diskusi') ?>" class="inline-flex items-center gap-2 text-sm font-medium text-burlap-700 transition hover:text-burlap-900">
            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Kembali ke Manajemen Diskusi
          </a>
        </div>

        <!-- Header -->
        <section class="mb-8 overflow-hidden rounded-2xl border border-amber-100 bg-white/90 p-6 shadow-xl backdrop-blur-sm sm:p-8">
          <p class="text-sm font-semibold uppercase tracking-wide text-amber-700">
            Detail Diskusi
          </p>

          <h1 class="mt-3 text-2xl font-bold tracking-tight text-stone-800 sm:text-3xl lg:text-4xl">
            <?= esc($kelas['nama_kelas'] ?? '-') ?>
          </h1>

          <p class="mt-4 max-w-2xl text-sm leading-6 text-stone-600 sm:text-base">
            Daftar pesan diskusi dari siswa dan guru dalam kelas ini.
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

        <!-- Diskusi List -->
        <section class="space-y-4">
          <?php if (empty($komentar)) : ?>
            <div class="rounded-2xl border border-burlap-200 bg-white/90 px-6 py-12 text-center shadow-md backdrop-blur-sm">
              <div class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-burlap-100 text-burlap-600">
                <svg class="h-8 w-8" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                </svg>
              </div>

              <h2 class="text-lg font-semibold text-stone-800">
                Belum ada diskusi
              </h2>

              <p class="mt-2 text-sm text-stone-500">
                Belum ada pesan diskusi yang dikirimkan dalam kelas ini.
              </p>
            </div>
          <?php else : ?>
            <?php foreach ($komentar as $k) : ?>
              <?php
                $namaUser = $k['nama_user'] ?? 'Pengguna';
                $inisialUser = strtoupper(mb_substr($namaUser, 0, 1));
                $createdAt = $k['created_at'] ?? null;
              ?>

              <article class="overflow-hidden rounded-2xl border border-burlap-200 bg-white/90 shadow-md backdrop-blur-sm">
                <div class="border-b border-burlap-200 bg-burlap-50 px-6 py-4">
                  <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
                    <div class="flex items-center gap-3">
                      <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-amber-100 text-sm font-bold text-amber-700">
                        <?= esc($inisialUser) ?>
                      </div>

                      <div>
                        <h3 class="text-sm font-semibold text-stone-800">
                          <?= esc($namaUser) ?>
                        </h3>

                        <p class="text-xs text-stone-500">
                          <?php if ($createdAt) : ?>
                            <time datetime="<?= esc($createdAt) ?>">
                              <?= esc(date('d F Y - H:i', strtotime($createdAt))) ?>
                            </time>
                          <?php else : ?>
                            -
                          <?php endif; ?>
                        </p>
                      </div>
                    </div>

                    <form
                      action="<?= base_url('admin/diskusi/hapus/' . ($k['id'] ?? 0)) ?>"
                      method="post"
                      onsubmit="return confirm('Yakin ingin menghapus komentar ini?')"
                    >
                      <?= csrf_field() ?>

                      <button
                        type="submit"
                        class="inline-flex w-full items-center justify-center rounded-lg bg-red-100 px-4 py-2.5 text-sm font-semibold text-red-700 transition hover:bg-red-200 sm:w-auto"
                      >
                        Hapus
                      </button>
                    </form>
                  </div>
                </div>

                <div class="p-6">
                  <p class="text-sm leading-6 text-stone-700">
                    <?= nl2br(esc($k['pesan'] ?? '')) ?>
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