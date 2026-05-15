<?php

class Controller_Auth extends Controller_Template
{
    public $template = 'template';

    const GROUP_ADMIN = 100;

    /**
     * ĐĂNG KÝ
     */
    public function action_register()
    {
        if (\Auth::check()) {
            return $this->redirect_by_role();
        }

        if (\Input::method() === 'POST') {

            $username = $this->post('username');
            $password = $this->post('password');
            $email    = $this->post('email');

            $val = \Validation\UserValidation::validate();

            if (!$val->run()) {

                \Session::set_flash(
                    'error',
                    'Thông tin đăng ký không hợp lệ.'
                );

                return;
            }

            try {

                $this->ensure_user_not_exists($username, $email);
                $token = \Str::random('alnum', 32);
                $user_id = $this->create_user($username, $password, $email, $token);
                $this->update_user($user_id, $token);
                $this->handle_activation_mail($email, $username, $token);
                return \Response::redirect('auth/login');
            } catch (\Exception $e) {

                \Session::set_flash(
                    'error',
                    $e->getMessage()
                );
            }
        }
        return $this->render_register();
    }
    /**
     * TẠO USER
     */
    protected function create_user($username, $password, $email, $token)
    {
        $user_id = \Auth::create_user(
            $username,
            $password,
            $email,
            1,
            [
                'is_active'        => 0,
                'activation_token' => $token
            ]
        );

        if (!$user_id) {
            throw new \Exception(
                'Không thể tạo tài khoản.'
            );
        }

        return $user_id;
    }

    /**
     * UPDATE USER
     */
    protected function update_user($user_id, $token)
    {
        $user = \Model_User::find($user_id);

        if (!$user) {
            throw new \Exception(
                'Không tìm thấy tài khoản.'
            );
        }

        $user->is_active        = $token ? 0 : 1;
        $user->activation_token = $token;

        return $user->save();
    }
    /**
     * KÍCH HOẠT
     */
    public function action_activate($token = null)
    {
        if (empty($token)) {
            return \Response::redirect('auth/login');
        }

        $user = \Model_User::find('first', [
            'where' => [
                ['activation_token', '=', $token],
                ['is_active', '=', 0]
            ]
        ]);

        if (!$user) {

            \Session::set_flash(
                'error',
                'Mã xác thực không hợp lệ hoặc tài khoản đã kích hoạt.'
            );

            return \Response::redirect('auth/login');
        }
        $this->update_user($user->id, null);
        \Session::set_flash(
            'success',
            'Kích hoạt tài khoản thành công.'
        );

        return \Response::redirect('auth/login');
    }

    /**
     * ĐĂNG NHẬP
     */
    public function action_login()
    {
        if (\Auth::check()) {
            return $this->redirect_by_role();
        }

        if (\Input::method() === 'POST') {

            $username = $this->post('username');
            $password = $this->post('password');

            if (!\Auth::login($username, $password)) {

                \Session::set_flash(
                    'error',
                    'Tên đăng nhập hoặc mật khẩu không chính xác.'
                );

                return;
            }

            $user = $this->current_user();

            if (!$user || (int) $user->is_active === 0) {

                \Auth::logout();

                \Session::set_flash(
                    'error',
                    'Tài khoản chưa được kích hoạt.'
                );

                return \Response::redirect('auth/login');
            }

            if (\Input::post('remember')) {
                \Auth::remember_me();
            }

            \Session::set_flash(
                'success',
                'Chào mừng bạn quay trở lại!'
            );

            return $this->redirect_by_role();
        }

        return $this->render_login();
    }

    /**
     * ĐĂNG XUẤT
     */
    public function action_logout()
    {
        \Auth::logout();

        return \Response::redirect('auth/login');
    }

    /**
     * REDIRECT BY ROLE
     */
    protected function redirect_by_role()
    {
        return \Response::redirect(
            \Auth::get('group') == self::GROUP_ADMIN
                ? 'admin'
                : 'user'
        );
    }

    /**
     * RENDER LOGIN
     */
    protected function render_login()
    {
        $this->template->title = 'Đăng nhập';

        $this->template->content = \View::forge('auth/login');

        return $this->template;
    }

    /**
     * RENDER REGISTER
     */
    protected function render_register()
    {
        $this->template->title = 'Đăng ký';

        $this->template->content = \View::forge('auth/register');

        return $this->template;
    }

    /**
     * TRIM POST INPUT
     */
    protected function post($key, $default = null)
    {
        return trim(\Input::post($key, $default));
    }

    /**
     * USER HIỆN TẠI
     */
    protected function current_user()
    {
        $auth_user = \Auth::get_user_id();

        return isset($auth_user[1])
            ? \Model_User::find($auth_user[1])
            : null;
    }

    /**
     * KIỂM TRA USER TỒN TẠI
     */
    protected function ensure_user_not_exists($username, $email)
    {
        $exists = \Model_User::find('first', [
            'where' => [
                ['username', '=', $username],
                'or' => [
                    ['email', '=', $email]
                ]
            ]
        ]);

        if ($exists) {
            throw new \Exception(
                'Tên đăng nhập hoặc Email đã tồn tại.'
            );
        }
    }

    /**
     * HANDLE MAIL KÍCH HOẠT
     */
    protected function handle_activation_mail($email, $username, $token)
    {
        try {

            $this->send_activation_email($email, $username, $token);

            \Session::set_flash(
                'success',
                'Đăng ký thành công! Vui lòng kiểm tra Email để kích hoạt.'
            );
        } catch (\Exception $e) {

            \Log::error(
                'Mail Error: ' . $e->getMessage()
            );

            \Session::set_flash(
                'success',
                'Đăng ký thành công nhưng không gửi được email.'
            );
        }
    }

    /**
     * GỬI EMAIL KÍCH HOẠT
     */
    protected function send_activation_email($email_to, $username, $token)
    {
        $link = \Uri::create('auth/activate/' . $token);

        $email = \Email::forge();

        $email->from(
            'no-reply@library.com',
            'Hệ thống Thư viện'
        );

        $email->to($email_to);

        $email->subject(
            '🔑 Kích hoạt tài khoản Thư viện của bạn'
        );

        $html_body = "
        <div style='background:#f0f0f0;padding:40px;font-family:sans-serif;'>
            <div style='max-width:500px;margin:0 auto;background:#fff;border:4px solid #000;box-shadow:10px 10px 0 #000;padding:30px;'>

                <h1 style='font-size:24px;font-weight:900;text-transform:uppercase;margin-top:0;'>
                    Chào {$username}!
                </h1>

                <p style='font-size:16px;line-height:1.5;color:#333;'>
                    Chào mừng bạn đến với hệ thống thư viện.
                    Chỉ còn một bước nữa thôi để bắt đầu khám phá kho sách khổng lồ.
                </p>

                <div style='margin:30px 0;text-align:center;'>
                    <a
                        href='{$link}'
                        style='display:inline-block;background:#000;color:#fff;text-decoration:none;padding:15px 30px;font-weight:900;font-size:18px;border:2px solid #000;'
                    >
                        XÁC THỰC TÀI KHOẢN
                    </a>
                </div>

                <p style='font-size:14px;color:#666;'>
                    Hoặc copy đường dẫn này dán vào trình duyệt:
                </p>

                <p style='font-size:12px;word-break:break-all;color:#000;background:#eee;padding:10px;'>
                    {$link}
                </p>

                <hr style='border:none;border-top:2px solid #000;margin:20px 0;'>

                <p style='font-size:12px;color:#999;margin-bottom:0;'>
                    Nếu bạn không thực hiện đăng ký này, vui lòng bỏ qua email.
                    <br>
                    &copy; 2026 Thư viện số.
                </p>

            </div>
        </div>
        ";

        $email->html_body($html_body);

        $email->alt_body(
            "Chào {$username}, vui lòng kích hoạt tài khoản tại link: {$link}"
        );

        try {

            $email->send();
        } catch (\EmailSendingException $e) {

            \Log::error(
                'Mail Error: ' . $e->getMessage()
            );

            throw $e;
        }
    }
}
