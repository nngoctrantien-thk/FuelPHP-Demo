<?php

class Service_QueueService
{
    /**
     * PUSH JOB
     */
    public static function push($type,array $payload,$delay = 0) {
        $queue = Model_Queue::forge([

            'type' => $type,

            'payload' => json_encode($payload),

            'status' => 'pending',

            'attempts' => 0,

            'available_at' => time() + $delay,
        ]);

        return $queue->save();
    }

    /**
     * LẤY JOB
     */
    public static function get_next_job()
    {
        return Model_Queue::find('first', [

            'where' => [

                ['status', '=', 'pending'],

                ['available_at', '<=', time()],
            ],

            'order_by' => [
                ['id', 'asc']
            ]
        ]);
    }

    /**
     * ĐÁNH DẤU PROCESSING
     */
    public static function mark_processing($job)
    {
        $job->status = 'processing';

        return $job->save();
    }

    /**
     * ĐÁNH DẤU DONE
     */
    public static function mark_done($job)
    {
        $job->status = 'done';

        $job->processed_at = time();

        return $job->save();
    }

    /**
     * ĐÁNH DẤU FAILED
     */
    public static function mark_failed(
        $job,
        $error
    ) {
        $job->status = 'failed';

        $job->attempts += 1;

        $job->error_text = $error;

        return $job->save();
    }
}