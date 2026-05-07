<?php

class Service_BorrowService
{
    public static function borrow_book(
        $user_id,
        $book_id
    ) {
        $book = Model_Book::find($book_id);

        if (!$book) {
            throw new Exception(
                'Book not found.'
            );
        }

        if ($book->available_copies <= 0) {
            throw new Exception(
                'Book unavailable.'
            );
        }

        DB::start_transaction();

        try {
            Model_Borrow::forge(array(
                'user_id'       => $user_id,
                'book_id'       => $book_id,
                'borrowed_at'   => time(),
                'due_date'      => strtotime('+7 days'),
                'status'        => 'borrowing',
            ))->save();

            $book->available_copies--;

            $book->save();

            DB::commit_transaction();
        } catch (Exception $e) {
            DB::rollback_transaction();

            throw $e;
        }
    }
}
