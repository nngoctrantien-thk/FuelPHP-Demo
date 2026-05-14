
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Đăng ký hệ thống</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; display: flex; align-items: center; height: 100vh; }
        .login-form { width: 100%; max-width: 400px; margin: auto; padding: 15px; }
    </style>
</head>
<body>
    <div class="login-form shadow-lg bg-white p-4 rounded">
        <h2 class="text-center mb-4">Đăng ký</h2>
         <?= View::forge('admin/partials/flash'); ?>
        <form method="post">
            <div class="mb-3">
                <label class="form-label">Tài khoản</label>
                <input type="text" name="username" class="form-control" placeholder="Username" required>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Mật khẩu</label>
                <input type="password" name="password" class="form-control" placeholder="Password" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" placeholder="Email" required>
            </div>

            <button type="submit" class="btn btn-primary w-100">Đăng ký</button>
            
            <?php if (isset($error)): ?>
                <div class="alert alert-danger mt-3 py-2"><?php echo $error; ?></div>
            <?php endif; ?>
        </form>
    </div>
</body>
</html>