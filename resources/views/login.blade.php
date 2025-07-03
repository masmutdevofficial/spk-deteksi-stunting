<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Login Area</title>
  <link rel="stylesheet" href="{{ asset('assets/css/adminlte.min.css') }}">
</head>
<body class="hold-transition login-page">
@include('layouts.alerts')

<div class="login-box">
  <div class="text-center mb-3">
    <h5><strong>SISTEM PAKAR DETEKSI DINI STATUS STUNTING BALITA<br>MENGGUNAKAN METODE NAÏVE BAYES</strong></h5>
  </div>

  <div class="card">
    <div class="card-body text-center">
      <h4>Pilih Jenis Login</h4>
      <a href="{{ route('login.admin.form') }}" class="btn btn-primary btn-block mt-3">
        Login Admin
      </a>
      <a href="{{ route('login.tenaga.form') }}" class="btn btn-success btn-block">
        Login Tenaga Medis
      </a>
    </div>
  </div>
</div>

<script src="{{ asset('assets/js/adminlte.min.js') }}"></script>
<script>
    setTimeout(() => {
        const toast = document.getElementById('liveToast');
        if (toast) {
            toast.classList.remove('show');
            toast.classList.add('fade');
            setTimeout(() => toast.remove(), 500);
        }
    }, 3000);
</script>
</body>
</html>
