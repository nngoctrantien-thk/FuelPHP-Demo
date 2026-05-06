<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Đăng nhập hệ thống</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            display: flex;
            align-items: center;
            height: 100vh;
        }

        .login-form {
            width: 100%;
            max-width: 400px;
            margin: auto;
            padding: 15px;
        }
    </style>
</head>

<body>
    <div class="login-form shadow-lg bg-white p-4 rounded">
        <h2 class="text-center mb-4">Đăng nhập</h2>
        <?php if ($message = Session::get_flash('message')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?php echo $message; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <?php if ($err_msg = Session::get_flash('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?php echo $err_msg; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
        <form method="post">
            <div class="mb-3">
                <label class="form-label">Tài khoản</label>
                <input type="text" name="username" class="form-control" placeholder="Username" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Mật khẩu</label>
                <input type="password" name="password" class="form-control" placeholder="Password" required>
            </div>

            <div class="mb-3 form-check">
                <input type="checkbox" name="remember" value="1" class="form-check-input" id="remember">
                <label class="form-check-label" for="remember">Ghi nhớ đăng nhập</label>
            </div>

            <button type="submit" class="btn btn-primary w-100">Đăng nhập</button>

            <div class="mt-3 text-center">
                <a href="<?php echo Uri::create('auth/register'); ?>" class="text-decoration-none">Chưa có tài khoản? Đăng ký</a>
            </div>

            <?php if (isset($error)): ?>
                <div class="alert alert-danger mt-3 py-2"><?php echo $error; ?></div>
            <?php endif; ?>
        </form>
    </div>
</body>
</html>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>