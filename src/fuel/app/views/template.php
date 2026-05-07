<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<?php echo Asset::css('bootstrap.css'); ?>
	<style>
		body {
			margin: 40px;
		}
	</style>
</head>

<body>
	<div class="container">
		<div class="content">
			<div class="container mt-4">
				<div class="d-flex justify-content-between align-items-center mb-4">
					<h2>Quản lý post</h2>
					<button type="button"
						class="btn btn-outline-danger btn-sm"
						onclick="window.location.href='<?php echo Uri::create('auth/logout'); ?>'">
						<i class="bi bi-box-arrow-right"></i> Đăng xuất
					</button>
				</div>

				<?php $subnav = isset($subnav) ? $subnav : array(); ?>
				<ul class="nav nav-pills mb-4">
					<li class="nav-item">
						<a class="nav-link <?php echo Arr::get($subnav, "index"); ?>" href="<?php echo Uri::create('post/index'); ?>">Danh sách</a>
					</li>
					<li class="nav-item">
						<a class="nav-link <?php echo Arr::get($subnav, "create"); ?>" href="<?php echo Uri::create('post/create'); ?>">Tạo mới</a>
					</li>
					<li class="nav-item">
						<a class="nav-link <?php echo Arr::get($subnav, "update"); ?>" href="<?php echo Uri::create('post/update'); ?>">Cập nhật</a>
					</li>
					<li class="nav-item">
						<a class="nav-link <?php echo Arr::get($subnav, "delete"); ?>" href="<?php echo Uri::create('post/delete'); ?>">Xóa</a>
					</li>
				</ul>

				<?php echo $content; ?>
			</div>
		</div>
	</div>
</body>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</html>