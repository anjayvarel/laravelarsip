<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Login - E-Arsip UPTD</title>

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <link href="{{ asset('template/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet" />
  <link href="{{ asset('template/css/sb-admin-2.min.css') }}" rel="stylesheet" />

  <style>
    body {
      font-family: 'Inter', sans-serif;
      margin: 0;
      padding: 0;
      min-height: 100vh;
      background: linear-gradient(to bottom right, #004e92, #000428);
      display: flex;
      align-items: center;
      justify-content: center;
      position: relative;
      overflow: hidden;
    }

    .svg-bg {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      z-index: 0;
    }

    .login-box {
      position: relative;
      z-index: 1;
      background: #fff;
      padding: 40px 30px;
      border-radius: 16px;
      box-shadow: 0 10px 40px rgba(0,0,0,0.2);
      width: 100%;
      max-width: 420px;
      text-align: center;
    }

    .login-box img {
      max-height: 100px;
      margin-bottom: 20px;
    }

    h2 {
      font-size: 20px;
      font-weight: 700;
      margin-bottom: 30px;
      color: #222;
    }

    .form-control-user {
      border-radius: 8px;
      padding: 12px 15px;
    }

    .btn-user {
      border-radius: 8px;
      font-weight: 600;
      background-color: #004e92;
    }

    .btn-user:hover {
      background-color: #003973;
    }

    .remember-me {
      font-size: 0.9rem;
      text-align: left;
    }

    .input-group-append .btn {
      background: #eee;
      border: none;
    }

    @media (max-width: 576px) {
      .login-box {
        margin: 20px;
      }
    }
  </style>
</head>
<body>


  <!-- SVG WAVE BACKGROUND -->
  <svg class="svg-bg" viewBox="0 0 1440 320">
    <path fill="#ffffff22" fill-opacity="1" d="M0,128L60,144C120,160,240,192,360,181.3C480,171,600,117,720,96C840,75,960,85,1080,101.3C1200,117,1320,139,1380,149.3L1440,160L1440,0L1380,0C1320,0,1200,0,1080,0C960,0,840,0,720,0C600,0,480,0,360,0C240,0,120,0,60,0L0,0Z"></path>
  </svg>

  @error('nip')
<script>
  Swal.fire({
    icon: 'error',
    title: 'Login Gagal',
    text: '{{ $message }}',
  });
</script>
@enderror

@if(session('success'))
<script>
  Swal.fire({
    icon: 'success',
    title: 'Berhasil Login!',
    text: '{{ session('success') }}',
    timer: 2000,
    showConfirmButton: false
  });
</script>
@endif
@if(session('success'))
<script>
  Swal.fire({
    icon: 'success',
    title: 'Logout Berhasil',
    text: '{{ session('success') }}',
    timer: 2000,
    showConfirmButton: false
  });
</script>
@endif

@if (session('success'))
<script>
  Swal.fire({
    icon: 'success',
    title: 'Berhasil!',
    text: '{{ session('success') }}',
    timer: 2000,
    showConfirmButton: false,
  });
</script>
@endif

  <div class="login-box">
    <img src="{{ asset('template/img/uptd.png') }}" alt="Logo UPTD">
    <h2>Sistem Informasi Pengelolaan Arsip<br>UPTD Badung Utara</h2>

    <form method="POST" action="{{ route('login') }}">
      @csrf
    
      <div class="form-group">
        <input type="text" name="nip" class="form-control form-control-user" placeholder="NIP" required autofocus>
      </div>
    
      <div class="form-group">
        <div class="input-group">
          <input type="password" name="password" class="form-control form-control-user" id="passwordInput" placeholder="Password" required>
          <div class="input-group-append">
            <button class="btn" type="button" onclick="togglePassword()">
              <i class="fas fa-eye" id="toggleIcon"></i>
            </button>
          </div>
        </div>
      </div>
    
      <div class="form-group form-check remember-me">
        <input type="checkbox" class="form-check-input" id="remember" name="remember">
        <label class="form-check-label" for="remember">Ingat Saya</label>
      </div>
    
      <button type="submit" class="btn btn-user btn-block text-white">Login</button>
    </form>
    
  </div>

  <script>
    function togglePassword() {
      const input = document.getElementById('passwordInput');
      const icon = document.getElementById('toggleIcon');

      if (input.type === 'password') {
        input.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
      } else {
        input.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
      }
    }
  </script>
</body>
</html>
