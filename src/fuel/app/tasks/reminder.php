<?php

namespace Fuel\Tasks;

class Reminder
{
    /**
     * NHẮC TRẢ SÁCH + QUÁ HẠN
     */
    public function return_books()
    {
        $now = time();

        echo PHP_EOL;
        echo '========================================' . PHP_EOL;
        echo '[REMINDER TASK] START' . PHP_EOL;
        echo '========================================' . PHP_EOL;

        /**
         * SẮP ĐẾN HẠN
         */
        $target_day = strtotime('+7 day');

        $start = strtotime(date('Y-m-d 00:00:00', $target_day));
        $end   = strtotime(date('Y-m-d 23:59:59', $target_day));

        echo PHP_EOL;
        echo '[REMINDER] checking upcoming due books...' . PHP_EOL;

        $reminder_borrows = \Model_Borrow::find('all', [
            'where' => [
                ['status', '=', 'borrowing'],
                ['returned_at', '=', null],
                ['due_date', '>=', $start],
                ['due_date', '<=', $end],
            ]
        ]);

        echo '[REMINDER] found: ' . count($reminder_borrows) . PHP_EOL;

        $reminder_queued = 0;

        foreach ($reminder_borrows as $borrow) {

            try {

                \Service_QueueService::push(
                    'send_return_reminder',
                    [
                        'borrow_id' => $borrow->id
                    ]
                );

                $reminder_queued++;

                echo '[REMINDER QUEUED] Borrow ID: ' . $borrow->id . PHP_EOL;

            } catch (\Exception $e) {

                echo '[REMINDER FAILED] Borrow ID: ' . $borrow->id . PHP_EOL;
                echo '[ERROR] ' . $e->getMessage() . PHP_EOL;

                \Log::error(
                    '[REMINDER_QUEUE_ERROR] ' . $e->getMessage()
                );
            }
        }

        /**
         * QUÁ HẠN
         */
        echo PHP_EOL;
        echo '[OVERDUE] checking overdue books...' . PHP_EOL;

        $overdue_borrows = \Model_Borrow::find('all', [
            'where' => [
                ['status', '=', 'borrowing'],
                ['returned_at', '=', null],
                ['due_date', '<', $now],
            ]
        ]);

        echo '[OVERDUE] found: ' . count($overdue_borrows) . PHP_EOL;

        $overdue_queued = 0;

        foreach ($overdue_borrows as $borrow) {

            try {

                \Service_QueueService::push(
                    'send_overdue_mail',
                    [
                        'borrow_id' => $borrow->id
                    ]
                );

                $overdue_queued++;

                echo '[OVERDUE QUEUED] Borrow ID: ' . $borrow->id . PHP_EOL;

            } catch (\Exception $e) {

                echo '[OVERDUE FAILED] Borrow ID: ' . $borrow->id . PHP_EOL;
                echo '[ERROR] ' . $e->getMessage() . PHP_EOL;

                \Log::error(
                    '[OVERDUE_QUEUE_ERROR] ' . $e->getMessage()
                );
            }
        }

        echo PHP_EOL;
        echo '========================================' . PHP_EOL;
        echo '[REMINDER TASK] DONE' . PHP_EOL;
        echo '[REMINDER QUEUED] ' . $reminder_queued . PHP_EOL;
        echo '[OVERDUE QUEUED] ' . $overdue_queued . PHP_EOL;
        echo '========================================' . PHP_EOL;
        echo PHP_EOL;
    }
}