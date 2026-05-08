<?php

class Service_BorrowService
{
    /*
    |--------------------------------------------------------------------------
    | BORROW BOOK
    |--------------------------------------------------------------------------
    */

    public static function borrow_book(
        $user_id,
        $book_id
    ) {

        /*
        |--------------------------------------------------------------------------
        | FIND BOOK
        |--------------------------------------------------------------------------
        */

        $book = Model_Book::find($book_id);

        if (!$book) {

            throw new Exception(
                'Book not found.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | CHECK AVAILABLE
        |--------------------------------------------------------------------------
        */

        if ($book->available_copies <= 0) {

            throw new Exception(
                'Book unavailable.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | CHECK USER BORROWING
        |--------------------------------------------------------------------------
        */

        $exists = Model_Borrow::query()

            ->where('user_id', $user_id)

            ->where('book_id', $book_id)

            ->where('status', 'borrowing')

            ->get_one();

        if ($exists) {

            throw new Exception(
                'You already borrowed this book.'
            );
        }

        DB::start_transaction();

        try {

            /*
            |--------------------------------------------------------------------------
            | CREATE BORROW
            |--------------------------------------------------------------------------
            */

            $borrow = Model_Borrow::forge(array(

                'user_id' => $user_id,

                'book_id' => $book_id,

                'borrowed_at' => time(),

                'due_date' => strtotime('+7 days'),

                'status' => 'borrowing',
            ));

            $borrow->save();

            /*
            |--------------------------------------------------------------------------
            | UPDATE BOOK STOCK
            |--------------------------------------------------------------------------
            */

            $book->available_copies -= 1;

            $book->save();

            DB::commit_transaction();

            return $borrow;

        } catch (Exception $e) {

            DB::rollback_transaction();

            throw $e;
        }
    }

    /*
    |--------------------------------------------------------------------------
    | RETURN BOOK
    |--------------------------------------------------------------------------
    */

    public static function return_book($borrow_id)
    {

        $borrow = Model_Borrow::find($borrow_id);

        if (!$borrow) {

            throw new Exception(
                'Borrow record not found.'
            );
        }

        if ($borrow->status == 'returned') {

            throw new Exception(
                'Book already returned.'
            );
        }

        DB::start_transaction();

        try {

            /*
            |--------------------------------------------------------------------------
            | UPDATE BORROW
            |--------------------------------------------------------------------------
            */

            $borrow->status = 'returned';

            $borrow->returned_at = time();

            $borrow->save();

            /*
            |--------------------------------------------------------------------------
            | UPDATE BOOK STOCK
            |--------------------------------------------------------------------------
            */

            $book = Model_Book::find($borrow->book_id);

            if ($book) {

                $book->available_copies += 1;

                $book->save();
            }

            DB::commit_transaction();

        } catch (Exception $e) {

            DB::rollback_transaction();

            throw $e;
        }
    }

    /*
    |--------------------------------------------------------------------------
    | USER BORROW HISTORY
    |--------------------------------------------------------------------------
    */

    public static function get_user_borrows($user_id)
    {

        return Model_Borrow::find('all', array(

            'related' => array(
                'book',
            ),

            'where' => array(
                array('user_id', $user_id)
            ),

            'order_by' => array(
                'id' => 'desc'
            )
        ));
    }
}