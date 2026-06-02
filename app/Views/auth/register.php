<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register - SekulLegend</title>
  <!-- Tailwind CSS via CDN -->
  <script src="https://cdn.tailwindcss.com"></script>
  <!-- Font Google -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <script>
    tailwind.config = {
      theme: {
        extend: {
          fontFamily: {
            sans: ['Poppins', 'sans-serif'],
          },
        }
      }
    }
  </script>
</head>
<body class="flex flex-col justify-center items-center min-h-screen bg-amber-50">
  <!-- Gradient Background -->
  <div class="fixed inset-0 bg-gradient-to-br from-amber-50 to-stone-200 -z-10"></div>
  
  <div class="container mx-auto px-4 py-8 flex flex-col md:flex-row items-center justify-center gap-8">
    <div class="w-full md:w-1/2 max-w-md">
      <div class="bg-white p-8 rounded-xl shadow-lg border border-amber-100">
        <div class="flex items-center justify-center mb-8">
          <!-- Heading 1 SekulLegend -->
          <div class="text-4xl font-bold text-amber-700">SekulLegend</div>
        </div>

        <h2 class="text-xl font-bold mb-4 text-center text-stone-800">Registrasi Siswa</h2>

        <?php if(session()->getFlashdata('success')): ?>
          <div class="bg-green-100 text-green-700 p-3 rounded-lg mb-4 flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <?= session()->getFlashdata('success') ?>
          </div>
        <?php endif; ?>

        <form method="post" action="<?= base_url('/register') ?>">
          <div class="mb-4">
            <label for="nama" class="block text-sm font-medium text-stone-600 mb-1">Nama Lengkap</label>
            <input type="text" id="nama" name="nama" placeholder="Masukkan nama lengkap" required 
                  class="w-full p-3 border border-stone-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition">
          </div>
          
          <div class="mb-4">
            <label for="username" class="block text-sm font-medium text-stone-600 mb-1">Username</label>
            <input type="text" id="username" name="username" placeholder="Pilih username" required 
                  class="w-full p-3 border border-stone-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition">
          </div>
          
          <div class="mb-6">
            <label for="password" class="block text-sm font-medium text-stone-600 mb-1">Password</label>
            <input type="password" id="password" name="password" placeholder="Buat password" required 
                  class="w-full p-3 border border-stone-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition">
          </div>
          
          <button type="submit" 
                  class="w-full bg-amber-700 text-white py-3 px-4 rounded-lg font-medium hover:bg-amber-800 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2 transition duration-150 ease-in-out">
            Daftar Sekarang
          </button>
        </form>
        
        <div class="mt-6 text-center">
          <p class="text-stone-600">Sudah punya akun? 
            <a href="<?= base_url('/login') ?>" class="text-amber-700 font-medium hover:text-amber-800">
              Login
            </a>
          </p>
        </div>
      </div>
      
      <div class="mt-4 text-center text-stone-500 text-sm">
        &copy; 2023 SekulLegend. All rights reserved.
      </div>
    </div>
  </div>
</body>
</html>