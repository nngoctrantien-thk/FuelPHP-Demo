<?php

class Service_MailService
{
    const FROM_EMAIL = 'no-reply@library.com';
    const FROM_NAME  = 'Hệ thống Thư viện';

    /**
     * SEND MAIL
     */
    public static function send($to, $subject, $html_body, $alt_body = '')
    {
        $email = \Email::forge();

        $email->from(self::FROM_EMAIL, self::FROM_NAME);
        $email->to($to);
        $email->subject($subject);
        $email->html_body($html_body);
        $email->alt_body($alt_body);

        try {
            return $email->send();
        } catch (\EmailSendingException $e) {

            \Log::error('[MAIL_ERROR] ' . $e->getMessage());

            throw $e;
        }
    }

    /**
     * TEMPLATE MAIL
     */
    protected static function build_layout($title, $content, $color = '#000')
    {
        return "
        <div style='background:#f4f4f4;padding:40px;font-family:Arial,sans-serif;'>
            <div style='max-width:600px;margin:0 auto;background:#fff;border:3px solid {$color};padding:30px;'>

                <h1 style='margin-top:0;color:{$color};font-size:28px;'>
                    {$title}
                </h1>

                {$content}

                <hr style='margin:30px 0;'>

                <p style='font-size:12px;color:#999;margin-bottom:0;'>
                    &copy; 2026 Thư viện số
                </p>

            </div>
        </div>";
    }

    /**
     * MAIL KÍCH HOẠT
     */
    public static function send_activation_mail($email_to, $username, $token)
    {
        $link = \Uri::base(false) . 'auth/activate/' . $token;
        $subject = '🔑 Kích hoạt tài khoản Thư viện';

        $content = "
        <p>Chào <strong>{$username}</strong>,</p>

        <p>Vui lòng kích hoạt tài khoản thư viện của bạn.</p>

        <div style='margin:30px 0;text-align:center;'>
            <a href='{$link}'
               style='background:#000;color:#fff;padding:14px 28px;text-decoration:none;display:inline-block;font-weight:bold;'>
                KÍCH HOẠT TÀI KHOẢN
            </a>
        </div>

        <p>Hoặc mở link:</p>

        <p>{$link}</p>";

        $html_body = self::build_layout(
            'Kích hoạt tài khoản',
            $content
        );

        $alt_body = "Chào {$username}, vui lòng kích hoạt tài khoản: {$link}";

        return self::send(
            $email_to,
            $subject,
            $html_body,
            $alt_body
        );
    }

    /**
     * MAIL NHẮC TRẢ SÁCH
     */
    public static function send_return_reminder($borrow)
    {
        $user = $borrow->user;
        $book = $borrow->book;

        $subject = '📚 Nhắc nhở sắp đến hạn trả sách';

        $content = "
        <p>Xin chào <strong>{$user->username}</strong>,</p>

        <p>Bạn sắp đến hạn trả sách.</p>

        <div style='background:#f5f5f5;padding:20px;margin:20px 0;'>
            <p><strong>Sách:</strong> {$book->title}</p>
            <p><strong>Hạn trả:</strong> " . date('d/m/Y H:i', $borrow->due_date) . "</p>
        </div>

        <p>Vui lòng trả sách đúng hạn để tránh bị quá hạn.</p>";

        $html_body = self::build_layout(
            'Nhắc trả sách',
            $content,
            '#f59e0b'
        );

        $alt_body = "Bạn sắp đến hạn trả sách: {$book->title} - Hạn trả: " .
            date('d/m/Y H:i', $borrow->due_date);

        return self::send(
            $user->email,
            $subject,
            $html_body,
            $alt_body
        );
    }

    /**
     * MAIL QUÁ HẠN
     */
    public static function send_overdue_mail($borrow)
    {
        $user = $borrow->user;
        $book = $borrow->book;

        $days_overdue = floor((time() - $borrow->due_date) / 86400);

        $subject = '⚠️ Sách đã quá hạn trả';

        $content = "
        <p>Xin chào <strong>{$user->username}</strong>,</p>

        <p>Bạn đang giữ sách quá hạn.</p>

        <div style='background:#fff1f1;padding:20px;margin:20px 0;'>
            <p><strong>Sách:</strong> {$book->title}</p>
            <p><strong>Hạn trả:</strong> " . date('d/m/Y H:i', $borrow->due_date) . "</p>
            <p><strong>Quá hạn:</strong> {$days_overdue} ngày</p>
        </div>

        <p>Vui lòng trả sách sớm nhất có thể.</p>";

        $html_body = self::build_layout(
            'Sách quá hạn',
            $content,
            '#dc2626'
        );

        $alt_body = "Sách quá hạn: {$book->title} - Quá hạn {$days_overdue} ngày";

        return self::send(
            $user->email,
            $subject,
            $html_body,
            $alt_body
        );
    }
}