<?php

class Controller_Auth extends Controller_Template
{
    public function action_register()
    {
        $data = array();

        if (\Input::method() == 'POST') {
            $username = trim(\Input::post('username'));
            $password = trim(\Input::post('password'));
            $email    = trim(\Input::post('email'));

            // validate
            $val = \Validation::forge();

            $val->add('username', 'Username')
                ->add_rule('required')
                ->add_rule('min_length', 3)
                ->add_rule('max_length', 50);

            $val->add('password', 'Password')
                ->add_rule('required')
                ->add_rule('min_length', 6);

            $val->add('email', 'Email')
                ->add_rule('required')
                ->add_rule('valid_email');

            if ($val->run()) {
                try {
                    // kiểm tra username tồn tại
                    $exists = \DB::select()
                        ->from('users')
                        ->where('username', $username)
                        ->execute()
                        ->current();

                    if ($exists) {
                        \Session::set_flash(
                            'error',
                            'Username already exists.'
                        );

                        return \View::forge('auth/register', $data);
                    }

                    // tạo user thường group = 1
                    $user_id = \Auth::create_user(
                        $username,
                        $password,
                        $email,
                        1
                    );

                    if ($user_id) {
                        \Session::set_flash(
                            'success',
                            'Register successful. Please login.'
                        );

                        \Response::redirect('auth/login');
                    } else {
                        $data['error'] =
                            'Cannot create account.';
                    }
                } catch (\SimpleUserUpdateException $e) {
                    switch ($e->getCode()) {
                        case 2:
                            $data['error'] =
                                'Username already exists.';
                            break;

                        case 3:
                            $data['error'] =
                                'Email already exists.';
                            break;

                        default:
                            $data['error'] =
                                $e->getMessage();
                            break;
                    }

                    \Session::set_flash(
                        'error',
                        $data['error']
                    );
                } catch (\Exception $e) {
                    $data['error'] = $e->getMessage();

                    \Session::set_flash(
                        'error',
                        $data['error']
                    );
                }
            } else {
                $data['error'] = $val->error();

                \Session::set_flash(
                    'error',
                    'Validation failed.'
                );
            }
        }

        return \View::forge('auth/register', $data);
    }

    public function action_login()
    {
        $data = array();

        // đã login rồi
        if (\Auth::check()) {
            if (\Auth::get('group') == 100) {
                \Response::redirect('admin');
            }

            \Response::redirect('user');
        }

        if (\Input::method() == 'POST') {
            $username = trim(\Input::post('username'));
            $password = trim(\Input::post('password'));

            // validate
            $val = \Validation::forge();

            $val->add('username', 'Username')
                ->add_rule('required');

            $val->add('password', 'Password')
                ->add_rule('required');

            if ($val->run()) {
                if (\Auth::login($username, $password)) {
                    // remember me
                    if (\Input::post('remember')) {
                        \Auth::remember_me();
                    } else {
                        \Auth::dont_remember_me();
                    }

                    \Session::set_flash(
                        'success',
                        'Login successful.'
                    );

                    // admin
                    if (\Auth::get('group') == 100) {
                        \Response::redirect('admin');
                    }

                    // user thường
                    \Response::redirect('user');
                } else {
                    $data['error'] =
                        'Wrong username or password.';

                    \Session::set_flash(
                        'error',
                        $data['error']
                    );
                }
            } else {
                $data['error'] =
                    'Please enter username and password.';

                \Session::set_flash(
                    'error',
                    $data['error']
                );
            }
        }

        return \View::forge('auth/login', $data);
    }

    public function action_logout()
    {
        \Auth::dont_remember_me();

        // logout
        \Auth::logout();
        Response::redirect('auth/login');
    }
}
