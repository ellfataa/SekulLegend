<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>Login - SekulLegend</title>

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
        },
      },
    };
  </script>
</head>

<body class="min-h-screen font-sans bg-gradient-to-br from-amber-50 via-orange-50 to-stone-200">
  <main class="flex min-h-screen items-center justify-center px-4 py-8">
    <section class="w-full max-w-md">
      <div class="rounded-2xl border border-amber-100 bg-white/90 p-6 shadow-xl backdrop-blur-sm sm:p-8">
        
        <!-- Brand -->
        <div class="mb-8 text-center">
          <h1 class="text-4xl font-bold tracking-tight text-amber-700">
            SekulLegend
          </h1>
          <p class="mt-2 text-sm text-stone-500">
            Silakan masuk untuk melanjutkan
          </p>
        </div>

        <!-- Form Header -->
        <h2 class="mb-6 text-center text-2xl font-semibold text-stone-800">
          Login Akun
        </h2>

        <!-- Alert Error -->
        <?php if (session()->getFlashdata('error')) : ?>
          <div class="mb-5 flex items-start gap-3 rounded-lg border border-red-200 bg-red-50 p-4 text-sm text-red-700">
            <svg xmlns="http://www.w3.org/2000/svg" class="mt-0.5 h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <p><?= esc(session()->getFlashdata('error')) ?></p>
          </div>
        <?php endif; ?>

        <!-- Alert Success -->
        <?php if (session()->getFlashdata('success')) : ?>
          <div class="mb-5 flex items-start gap-3 rounded-lg border border-green-200 bg-green-50 p-4 text-sm text-green-700">
            <svg xmlns="http://www.w3.org/2000/svg" class="mt-0.5 h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <p><?= esc(session()->getFlashdata('success')) ?></p>
          </div>
        <?php endif; ?>

        <!-- Login Form -->
        <form method="post" action="<?= base_url('/login') ?>" class="space-y-5">
          <?= csrf_field() ?>

          <!-- Username -->
          <div>
            <label for="username" class="mb-2 block text-sm font-medium text-stone-700">
              Username
            </label>
            <input
              type="text"
              id="username"
              name="username"
              value="<?= esc(old('username')) ?>"
              placeholder="Masukkan username"
              required
              autocomplete="username"
              class="w-full rounded-lg border border-stone-300 bg-white px-4 py-3 text-sm text-stone-800 outline-none transition placeholder:text-stone-400 focus:border-amber-500 focus:ring-2 focus:ring-amber-200"
            >
          </div>

          <!-- Password -->
          <div>
            <label for="password" class="mb-2 block text-sm font-medium text-stone-700">
              Password
            </label>
            <input
              type="password"
              id="password"
              name="password"
              placeholder="Masukkan password"
              required
              autocomplete="current-password"
              class="w-full rounded-lg border border-stone-300 bg-white px-4 py-3 text-sm text-stone-800 outline-none transition placeholder:text-stone-400 focus:border-amber-500 focus:ring-2 focus:ring-amber-200"
            >
          </div>

          <!-- Submit -->
          <button
            type="submit"
            class="w-full rounded-lg bg-amber-700 px-4 py-3 font-semibold text-white shadow-md transition hover:bg-amber-800 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2"
          >
            Masuk
          </button>
        </form>

        <!-- Register Link -->
        <p class="mt-8 text-center text-sm text-stone-600">
          Belum punya akun?
          <a href="<?= base_url('/register') ?>" class="font-semibold text-amber-700 underline-offset-4 hover:text-amber-800 hover:underline">
            Daftar
          </a>
        </p>
      </div>

      <!-- Footer -->
      <p class="mt-6 text-center text-sm text-stone-500">
        &copy; 2023 SekulLegend. All rights reserved.
      </p>
    </section>
  </main>
</body>
</html>