<?php

class Controller_Auth extends Controller_Template
{
    public function action_register()
    {
        $data = array();
        if (Input::method() == 'POST') {
            try {
                Auth::create_user(
                    Input::post('username'),
                    Input::post('password'),
                    Input::post('email')
                );
                Session::set_flash('message', "Đăng ký thành công! Vui lòng đăng nhập.");
                Response::redirect('auth/login');
            } catch (Exception $e) {
                $data['error'] = "Lỗi: " . $e->getMessage();
                Session::set_flash('error', "Đăng ký thất bại! Vui lòng thử lại.");
            }
        }
        return View::forge('auth/register', $data);
    }

    public function action_login()
    {
        $data = array();
        if (Input::method() == 'POST') {
            if (Auth::login(Input::post('username'), Input::post('password'))) {
                if (\Input::param('remember', false)) {
                    // create the remember-me cookie
                    \Auth::remember_me();
                } else {
                    // delete the remember-me cookie if present
                    \Auth::dont_remember_me();
                }
                Response::redirect('admin/index');
            } else {
                $data['error'] = 'Sai tài khoản hoặc mật khẩu!';
            }
        }
        return View::forge('auth/login', $data);
    }

    public function action_logout()
    {
        \Auth::dont_remember_me();

        // logout
        \Auth::logout();
        Response::redirect('auth/login');
    }
}
