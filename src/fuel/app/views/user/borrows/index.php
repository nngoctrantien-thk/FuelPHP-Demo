<!-- ================= BORROWED BOOKS ================= -->

<section class="py-5 bg-light">

    <div class="container">

        <!-- TITLE -->

        <div class="row mb-5">

            <div class="col-md-12 text-center">

                <h2 class="fw-bold">

                    My Borrowed Books

                </h2>

                <p class="text">

                    List of books you are currently borrowing

                </p>

            </div>

        </div>

        <!-- BORROW LIST -->

        <div class="row">

            <?php if (!empty($borrows)): ?>

                <?php foreach ($borrows as $borrow): ?>

                    <?php

                    $book = $borrow->book;

                    $image = !empty($book->image)
                        ? $book->image
                        : 'no-image.jpg';

                    ?>

                    <div class="col-lg-4 col-md-6 mb-4">

                        <div class="card border-0 shadow-sm h-100">

                            <!-- BOOK IMAGE -->

                            <?= Asset::img(
                                'books/' . $image,
                                array(
                                    'class' => 'card-img-top',
                                    'style' => '
                                        height:300px;
                                        object-fit:cover;
                                    ',
                                    'alt' => $book->title
                                )
                            ); ?>

                            <div class="card-body d-flex flex-column">

                                <!-- TITLE -->

                                <h5 class="card-title mb-3">

                                    <?= $book->title; ?>

                                </h5>

                                <!-- AUTHOR -->

                                <p class="mb-2">

                                    <strong>Author:</strong>

                                    <?=
                                    !empty($book->author)
                                        ? $book->author->name
                                        : 'Unknown Author';
                                    ?>

                                </p>

                                <!-- ISBN -->

                                <p class="mb-2">

                                    <strong>ISBN:</strong>

                                    <?= $book->isbn; ?>

                                </p>

                                <!-- BORROW DATE -->

                                <p class="mb-2">

                                    <strong>Borrow Date:</strong>

                                    <?= date(
                                        'd/m/Y',
                                        $borrow->borrowed_at
                                    ); ?>

                                </p>

                                <!-- RETURN DATE -->

                                <p class="mb-4">

                                    <strong>Due Date:</strong>

                                    <?= date(
                                        'd/m/Y',
                                        $borrow->due_date
                                    ); ?>

                                </p>

                                <!-- ACTIONS -->

                                <div class="mt-auto d-grid gap-2">

                                    <a href="/user/books/view/<?= $book->id; ?>"
                                        class="btn btn-outline-dark">

                                        View Details

                                    </a>

                                    <a href="/user/borrows/return/<?= $borrow->id; ?>"
                                        class="btn btn-dark"
                                        onclick="return confirm('Are you sure you want to return this book?')">

                                        Return Book

                                    </a>

                                </div>

                            </div>

                        </div>

                    </div>

                <?php endforeach; ?>

            <?php else: ?>

                <div class="col-md-12 text-center">

                    <div class="alert alert-secondary">

                        You have not borrowed any books yet.

                    </div>

                </div>

            <?php endif; ?>

        </div>

    </div>

</section>