<?php

class Controller_User extends Controller_Template
{
    public $template = 'user/template';

    public function action_index()
    {
        $data['books'] = \Model_Book::find(
            'all',
            array(
                'limit' => 4,
                'order_by' => array(
                    'id' => 'desc'
                )
            )
        );

        $this->template->title =
            'Library';

        $this->template->content =
            \View::forge(
                'user/index',
                $data
            );
    }
}