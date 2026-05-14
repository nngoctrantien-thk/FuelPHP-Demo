<?php
/**
 * FuelPHP Email Config
 */

return array(
    /**
     * Default setup group
     */
    'default_setup' => 'default',

    /**
     * Default settings
     */
    'defaults' => array(
        /**
         * Mail driver: Chuyển sang 'smtp'
         */
        'driver' => 'smtp',

        /**
         * Định dạng email gửi đi là HTML
         */
        'is_html' => true,

        'charset' => 'utf-8',
        'encoding' => '8bit',

        /**
         * Default sender details: 
         * Thay bằng email thật của bạn để tránh bị đánh dấu spam
         */
        'from' => array(
            'email' => 'your-email@gmail.com',
            'name'  => 'Library System',
        ),

        /**
         * SMTP settings
         */
        'smtp' => array(
            'host'     => 'smtp.gmail.com', 
            'port'     => 587,
            'username' => 'n_ngoctrantien@thk-hd.vn',
            'password' => 'q s f d o p s y y y e j t d n k',
            'timeout'  => 30,
            'starttls' => true,
            'options'  => array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true,
                ),
            ),
        ),
        'newline' => "\r\n",

        'remove_html_comments' => true,
    ),
);