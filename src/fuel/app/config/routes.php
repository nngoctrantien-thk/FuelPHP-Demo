<?php

/**
 * Fuel is a fast, lightweight, community driven PHP 5.4+ framework.
 *
 * @package    Fuel
 * @version    1.8.2
 * @author     Fuel Development Team
 * @license    MIT License
 * @copyright  2010 - 2019 Fuel Development Team
 * @link       https://fuelphp.com
 */

return array(
	/**
	 * -------------------------------------------------------------------------
	 *  Default route
	 * -------------------------------------------------------------------------
	 *
	 */

	'_root_' => 'auth/login',

	/**
	 * -------------------------------------------------------------------------
	 *  Page not found
	 * -------------------------------------------------------------------------
	 *
	 */

	'_404_' => 'welcome/404',
	// =========================================================
	// ADMIN
	// =========================================================

	'admin' => 'admin/index',

	// ---------------- BOOKS ----------------

	'admin/books' => 'admin/books/index',

	'admin/books/create' => 'admin/books/create',

	'admin/books/edit/(:num)' => 'admin/books/edit/$1',

	'admin/books/delete/(:num)' => 'admin/books/delete/$1',

	'admin/books/view/(:num)' => 'admin/books/view/$1',
	'admin/books/index/(:num)' => 'admin/books/index',

	// ================= USER =================
    
    // 1. Khi vào localhost/user trỏ thẳng về danh sách sách
    'user' => 'user/books/index', 

    // 2. Khi vào localhost/user/books cũng trỏ về index
    'user/books' => 'user/books/index',

	// 3. Khi vào localhost/user/books/index/2 sẽ trỏ về index với tham số trang là 2
    'user/books/index/(:num)' => 'user/books/index',

    // 4. Chi tiết sách
    'user/books/view/(:num)' => 'user/books/view/$1',
	// 5. User profile
	'user/profile' => 'user/profile/index',
	// 6. change password
	'user/profile/change_password' => 'user/profile/change_password',
	// 7. Edit profile
	'user/profile/edit' => 'user/profile/edit',
    // ---------------- BORROWS ----------------
    'user/borrows/create/(:num)' => 'user/borrows/create/$1',
    'user/borrowed'              => 'user/borrows/index',
);
