<?php

class Controller_Auth extends Controller_Template
{
    public $template = 'template';

    /**
     * ĐĂNG KÝ TÀI KHOẢN
     */
    public function action_register()
    {
        if (\Auth::check()) {
            \Response::redirect('user');
        }

        $data = array();

        if (\Input::method() == 'POST') {
            $username = trim(\Input::post('username'));
            $password = trim(\Input::post('password'));
            $email    = trim(\Input::post('email'));
            $val = \Validation\UserValidation::validate();
            if ($val->run()) {
                try {
                    $check_user = \Model_User::find('first', array(
                        'where' => array(
                            array('username', '=', $username),
                            'or' => array(
                                array('email', '=', $email)
                            )
                        )
                    ));

                    if ($check_user) {
                        throw new \Exception('Tên đăng nhập hoặc Email này đã được sử dụng.');
                    }
                    $token = \Str::random('alnum', 32);
                    $user_id = \Auth::create_user(
                        $username,
                        $password,
                        $email,
                        1,
                        array(
                            'is_active' => 0,
                            'activation_token' => $token
                        )
                    );

                    if ($user_id) {
                        $user = \Model_User::find($user_id);
                        $user->is_active = 0;
                        $user->activation_token = $token;
                        if ($user->save()) {
                            try {
                                $this->send_activation_email($email, $username, $token);
                                \Session::set_flash('success', 'Đăng ký thành công! Vui lòng kiểm tra Email để kích hoạt.');
                            } catch (\Exception $e) {
                                \Session::set_flash('success', 'Đăng ký thành công nhưng không thể gửi mail. Vui lòng liên hệ Admin.');
                            }

                            \Response::redirect('auth/login');
                        }
                    }
                } catch (\Exception $e) {
                    \Session::set_flash('error', $e->getMessage());
                }
            } else {
                \Session::set_flash('error', 'Thông tin đăng ký không hợp lệ. Vui lòng kiểm tra lại.');
            }
        }

        $this->template->title = 'Đăng ký thành viên';
        $this->template->content = \View::forge('auth/register', $data);
    }

    /**
     * KÍCH HOẠT TÀI KHOẢN
     */
    public function action_activate($token = null)
    {
        if (!$token) {
            \Response::redirect('auth/login');
        }

        $user = \Model_User::find('first', array(
            'where' => array(
                array('activation_token', '=', $token),
                array('is_active', '=', 0),
            ),
        ));

        if ($user) {
            $user->is_active = 1;
            $user->activation_token = null;
            $user->save();

            \Session::set_flash('success', 'Chúc mừng! Tài khoản của bạn đã được kích hoạt thành công. Bây giờ bạn có thể đăng nhập.');
        } else {
            \Session::set_flash('error', 'Mã xác thực không hợp lệ hoặc tài khoản đã được kích hoạt trước đó.');
        }

        \Response::redirect('auth/login');
    }

    /**
     * ĐĂNG NHẬP
     */
    public function action_login()
    {
        if (\Auth::check()) {
            \Response::redirect(\Auth::get('group') == 100 ? 'admin' : 'user');
        }

        $data = array();

        if (\Input::method() == 'POST') {
            $username = trim(\Input::post('username'));
            $password = trim(\Input::post('password'));

            if (\Auth::login($username, $password)) {
                $user_id_data = \Auth::get_user_id();
                $user = \Model_User::find($user_id_data[1]);

                if ($user && $user->is_active == 0) {
                    \Auth::logout();
                    \Session::set_flash('error', 'Tài khoản của bạn chưa được kích hoạt. Vui lòng kiểm tra email để xác thực.');
                    \Response::redirect('auth/login');
                }

                if (\Input::post('remember')) \Auth::remember_me();

                \Session::set_flash('success', 'Chào mừng bạn quay trở lại!');
                \Response::redirect(\Auth::get('group') == 100 ? 'admin' : 'user');
            } else {
                \Session::set_flash('error', 'Tên đăng nhập hoặc mật khẩu không chính xác.');
            }
        }

        $this->template->title = 'Đăng nhập';
        $this->template->content = \View::forge('auth/login', $data);
    }

    /**
     * Gửi email kích hoạt
     */
    protected function send_activation_email($email_to, $username, $token)
    {
        $email = \Email::forge();
        $email->from('no-reply@library.com', 'Hệ thống Thư viện');
        $email->to($email_to);
        $email->subject('🔑 Kích hoạt tài khoản Thư viện của bạn');

        $link = \Uri::create('auth/activate/' . $token);

        $html_body = "
        <div style='background-color: #f0f0f0; padding: 40px; font-family: sans-serif;'>
            <div style='max-width: 500px; margin: 0 auto; background: #ffffff; border: 4px solid #000000; box-shadow: 10px 10px 0px #000000; padding: 30px;'>
                <h1 style='font-size: 24px; font-weight: 900; text-transform: uppercase; margin-top: 0;'>Chào {$username}!</h1>
                <p style='font-size: 16px; line-height: 1.5; color: #333;'>Chào mừng bạn đến với hệ thống thư viện. Chỉ còn một bước nữa thôi để bắt đầu khám phá kho sách khổng lồ.</p>
                
                <div style='margin: 30px 0; text-align: center;'>
                    <a href='{$link}' style='display: inline-block; background: #000000; color: #ffffff; text-decoration: none; padding: 15px 30px; font-weight: 900; font-size: 18px; border: 2px solid #000000; transition: all 0.2s;'>
                        XÁC THỰC TÀI KHOẢN
                    </a>
                </div>

                <p style='font-size: 14px; color: #666;'>Hoặc copy đường dẫn này dán vào trình duyệt:</p>
                <p style='font-size: 12px; word-break: break-all; color: #000; background: #eee; padding: 10px;'>{$link}</p>
                
                <hr style='border: none; border-top: 2px solid #000; margin: 20px 0;'>
                <p style='font-size: 12px; color: #999; margin-bottom: 0;'>
                    Nếu bạn không thực hiện đăng ký này, vui lòng bỏ qua email. <br>
                    &copy; 2026 Thư viện số.
                </p>
            </div>
        </div>
        ";
        $email->html_body($html_body);

        $email->alt_body("Chào {$username}, vui lòng kích hoạt tài khoản tại link: {$link}");

        try {
            $email->send();
        } catch (\EmailSendingException $e) {
            \Log::error('Mail Error: ' . $e->getMessage());
        }
    }

    public function action_logout()
    {
        \Auth::logout();
        \Response::redirect('auth/login');
    }
}
