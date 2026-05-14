<?php

class Controller_User extends Controller_Template
{
    public $template = 'user/template';

    public function action_index()
    {
        $data = array();
        $this->template->title =
            'Library';

        $this->template->content =
            \View::forge(
                'user/index',
                $data
            );
    }
}