<?php

class Controller_Auth extends Controller_Template
{
    // Trang đăng ký thành viên mới
    public function action_register()
    {
        $data = array();
        if (Input::method() == 'POST') {
            try {
                // Tạo user mới bằng SimpleAuth
                Auth::create_user(
                    Input::post('username'),
                    Input::post('password'),
                    Input::post('email')
                );
                Response::redirect('auth/login');
            } catch (Exception $e) {
                $data['error'] = "Lỗi: " . $e->getMessage();
            }
        }
        $this->template->content = View::forge('auth/register', $data);
    }

    // Trang đăng nhập
    public function action_login()
    {
        $data = array();
        if (Input::method() == 'POST') {
            // Kiểm tra thông tin đăng nhập
            if (Auth::login(Input::post('username'), Input::post('password'))) {
                Response::redirect('admin/index');
            } else {
                $data['error'] = 'Sai tài khoản hoặc mật khẩu!';
            }
        }
        $this->template->content = View::forge('auth/login', $data);
    }

    // Đăng xuất
    public function action_logout()
    {
        Auth::logout();
        Response::redirect('auth/login');
    }
}
