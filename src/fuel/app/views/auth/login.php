<form method="post">
    <input type="text" name="username" placeholder="Username">
    <input type="password" name="password" placeholder="Password">
    <button type="submit">Đăng nhập</button>
    <button type="button" onclick="window.location.href='<?php echo Uri::create('auth/register'); ?>'">
        Đăng ký
    </button>
    <?php if (isset($error)): ?>
        <p style="color: red;"><?php echo $error; ?></p>
    <?php endif; ?>
</form>