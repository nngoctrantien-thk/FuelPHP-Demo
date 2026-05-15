<?php

class Controller_User_Profile extends Controller_Template
{
    public $template = 'template';

    public function before()
    {
        parent::before();
        if (!\Auth::check()) {
            \Response::redirect('auth/login');
        }
    }

    /**
     * Hiển thị trang cá nhân (View)
     */
    public function action_index()
    {
        // Lấy ID của user hiện tại
        $user_id = \Auth::get_user_id()[1];

        // Lấy dữ liệu user cùng với các quan hệ (ví dụ: borrows)
        $user = Model_User::find($user_id, array(
            'related' => array('borrows')
        ));

        $data["user"] = $user;
        $this->template->title = "User Profile";
        $this->template->content = View::forge('user/profile', $data);
    }

    /**
     * Xử lý cập nhật thông tin (Update)
     */
    public function action_update()
    {
        if (Input::method() == 'POST') {
            $user_id = \Auth::get_user_id()[1];
            $user = Model_User::find($user_id);

            // 1. Cập nhật các trường cơ bản
            $user->email = Input::post('email');
            
            // 2. Cập nhật profile_fields (thường lưu dạng array serialize)
            $profile_fields = array(
                'full_name' => Input::post('full_name'),
                'phone'     => Input::post('phone'),
            );
            $user->profile_fields = serialize($profile_fields);

            if ($user->save()) {
                Session::set_flash('success', 'Profile updated successfully!');
            } else {
                Session::set_flash('error', 'Could not update profile.');
            }
            
            Response::redirect('user/profile');
        }
    }

    /**
     * Trang đổi mật khẩu
     */
    public function action_change_password()
    {
        if (Input::method() == 'POST') {
            $old_pass = Input::post('old_password');
            $new_pass = Input::post('new_password');

            try {
                // Sử dụng hàm change_password của SimpleAuth hoặc BaseAuth
                if (\Auth::change_password($old_pass, $new_pass)) {
                    Session::set_flash('success', 'Password changed successfully!');
                    Response::redirect('user/profile');
                } else {
                    Session::set_flash('error', 'Old password is incorrect.');
                }
            } catch (\Auth\AuthException $e) {
                Session::set_flash('error', $e->getMessage());
            }
        }

        $this->template->title = "Change Password";
        $this->template->content = View::forge('user/change_password');
    }
}