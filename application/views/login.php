<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SPK Pemilihan Supplier</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.6)), 
                        url('https://images.unsplash.com/photo-1596450537237-77c8e9d99c37?q=80&w=1920&auto=format&fit=crop'); 
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }

        .login-card {
            background: #ffffff;
            width: 100%;
            max-width: 400px;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.3); /* Efek bayangan agar kotak terlihat melayang */
            text-align: center;
        }

        .logo-img {
            max-width: 120px;
            margin-bottom: 10px;
        }

        .login-title {
            font-weight: 700;
            color: #333;
            margin-bottom: 30px;
            font-size: 24px;
        }

        .form-group {
            margin-bottom: 20px;
            text-align: left;
        }

        .form-label {
            font-weight: 500;
            color: #555;
            font-size: 14px;
        }

        .form-control {
            height: 45px;
            border-radius: 6px;
            border: 1px solid #ddd;
            font-size: 14px;
        }

        .form-control:focus {
            border-color: #4e73df;
            box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
        }

        .btn-login {
            background-color: #4A90E2; /* Warna biru sesuai gambar referensi */
            border: none;
            color: white;
            width: 100%;
            height: 45px;
            font-weight: 600;
            border-radius: 6px;
            margin-top: 10px;
            transition: all 0.3s;
        }

        .btn-login:hover {
            background-color: #357ABD;
        }
        
        .copyright {
            margin-top: 20px;
            color: #ccc; /* Warna teks copyright terang agar terlihat di background gelap */
            font-size: 12px;
            position: absolute;
            bottom: 10px;
        }
    </style>
</head>
<body>

    <div class="login-card">
        <img src="<?= base_url('assets/img/ipj.png') ?>" alt="Logo JKP" class="logo-img">
        
        <h2 class="login-title">Login</h2>

        <?php if($this->session->flashdata('message')): ?>
            <div class="alert alert-danger" role="alert">
                <?= $this->session->flashdata('message'); ?>
            </div>
        <?php endif; ?>

        <form action="<?= site_url('Login/login'); ?>" method="post" class="user">
            <div class="form-group">
                <label for="username" class="form-label">Nama Pengguna</label>
                <input type="text" class="form-control" id="username" name="username" placeholder="Masukkan username" required>
            </div>
            
            <div class="form-group">
                <label for="password" class="form-label">Kata Sandi</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan password" required>
            </div>

            <button type="submit" class="btn btn-login">
                Masuk
            </button>
        </form>
    </div>

    <div class="copyright">
        &copy; 2026 SPK Pemilihan Supplier Ubi Jalar - CV. Inovasi Priangan Jaya
    </div>

</body>
</html>