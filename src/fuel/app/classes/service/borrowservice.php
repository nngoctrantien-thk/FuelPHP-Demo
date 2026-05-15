<?php

class Service_BorrowService
{
    /**
     * Lấy danh sách sách đang mượn của User
     */
    public static function get_active_borrows($user_id)
    {
        return Model_Borrow::query()
            ->related(['book', 'book.author'])
            ->where('user_id', $user_id)
            ->where('status', 'borrowing')
            ->order_by('id', 'desc')
            ->get();
    }

    /**
     * Lấy gợi ý sách cùng tác giả từ danh sách đang mượn
     */
    public static function get_suggestions_by_borrowed_authors($user_id)
    {
        $borrows = self::get_active_borrows($user_id);

        if (empty($borrows)) return [];

        $author_ids = [];
        $borrowed_book_ids = [];

        foreach ($borrows as $borrow) {
            if ($borrow->book) {
                $author_ids[] = $borrow->book->author_id;
                $borrowed_book_ids[] = $borrow->book_id;
            }
        }

        if (empty($author_ids)) return [];

        return Model_Book::query()
            ->related('author')
            ->where('author_id', 'in', array_unique($author_ids))
            ->where('id', 'not in', $borrowed_book_ids)
            ->where('available_copies', '>', 0)
            ->limit(8)
            ->get();
    }

    /**
     * Mượn sách
     */
    public static function borrow_book($user_id, $book_id)
    {
        DB::start_transaction();
        try {
            // LOCK ROW
            $book = Model_Book::query()
                ->where('id', $book_id)
                ->for_update()
                ->get_one();

            if (!$book) {
                throw new Exception('Book not found.');
            }

            // check stock SAU KHI LOCK
            if ($book->available_copies <= 0) {

                throw new Exception('This book is currently out of stock.');
            }

            $is_borrowing = Model_Borrow::query()
                ->where('user_id', $user_id)
                ->where('book_id', $book_id)
                ->where('status', 'borrowing')
                ->get_one();

            if ($is_borrowing) {

                throw new Exception('You are already borrowing this book.');
            }

            $borrow = Model_Borrow::forge([

                'user_id'     => $user_id,
                'book_id'     => $book_id,
                'borrowed_at' => time(),
                'due_date'    => strtotime('+7 days'),
                'status'      => 'borrowing',
            ]);

            $borrow->save();

            $book->available_copies -= 1;

            $book->save();

            DB::commit_transaction();

            return $borrow;
        } catch (Exception $e) {

            DB::rollback_transaction();

            throw $e;
        }
    }

    /**
     * Trả sách
     */
    public static function return_book($borrow_id, $user_id)
    {
        // Eager load luôn book để xử lý stock nhanh hơn
        $borrow = Model_Borrow::find($borrow_id, ['related' => ['book']]);

        if (!$borrow || $borrow->user_id != $user_id) {
            throw new Exception('Borrow record not found or access denied.');
        }

        if ($borrow->status == 'returned') {
            throw new Exception('This book has already been returned.');
        }

        DB::start_transaction();
        try {
            $borrow->status = 'returned';
            $borrow->returned_at = time();
            $borrow->save();

            if ($borrow->book) {
                $borrow->book->available_copies += 1;
                $borrow->book->save();
            }

            DB::commit_transaction();
            return true;
        } catch (Exception $e) {
            DB::rollback_transaction();
            throw $e;
        }
    }
}
