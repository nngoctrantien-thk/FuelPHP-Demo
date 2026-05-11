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

	// ================= USER =================

	'user' => 'user/index',

	// ---------------- BOOKS ----------------

	'user/books' => 'user/books/index',

	'user/books/view/(:num)' => 'user/books/view/$1',

	// ---------------- BORROWS ----------------

	'user/borrows/create/(:num)' => 'user/borrows/create/$1',

	'user/borrowed' => 'user/borrows/index',

	'user/borrows/return/(:num)' => 'user/borrows/return/$1',
);
