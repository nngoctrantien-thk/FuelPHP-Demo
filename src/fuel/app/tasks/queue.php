<?php

namespace Fuel\Tasks;

class Queue
{
    /**
     * WORKER
     */
    public function work()
    {
        echo PHP_EOL;
        echo '=== QUEUE WORKER START ===';
        echo PHP_EOL;

        while (true) {

            $job = \Service_QueueService::get_next_job();
            
            if (!$job) {
                
                sleep(5);
                continue;
            }
            try {

                \Service_QueueService::mark_processing(
                    $job
                );

                $payload = json_decode(
                    $job->payload,
                    true
                );
                
                switch ($job->type) {

                    case 'send_activation_mail':

                        \Service_MailService::send_activation_mail(

                            $payload['email'],

                            $payload['username'],

                            $payload['token']
                        );

                        break;

                    case 'send_return_reminder':

                        $borrow = \Model_Borrow::find(
                            $payload['borrow_id']
                        );

                        if ($borrow) {

                            \Service_MailService::send_return_reminder(
                                $borrow
                            );
                        }

                        break;

                    case 'send_overdue_mail':

                        $borrow = \Model_Borrow::find(
                            $payload['borrow_id']
                        );

                        if ($borrow) {

                            \Service_MailService::send_overdue_mail(
                                $borrow
                            );
                        }

                        break;
                }

                \Service_QueueService::mark_done(
                    $job
                );

                echo '[DONE] Job #' . $job->id . PHP_EOL;

            } catch (\Exception $e) {

                \Service_QueueService::mark_failed(
                    $job,
                    $e->getMessage()
                );

                echo '[FAILED] ' . $e->getMessage() . PHP_EOL;
            }
        }
    }
}