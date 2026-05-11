<!-- ================= HERO SECTION ================= -->

<section class="py-5 bg-light">

    <div class="container">

        <div class="row align-items-center">

            <!-- LEFT -->

            <div class="col-md-6">

                <h1 class="display-4 fw-bold mb-4">

                    Welcome to Library

                </h1>

                <p class="lead mb-4">

                    Explore thousands of books online
                    and borrow your favorite books easily.

                </p>
            </div>

            <!-- RIGHT -->

            <div class="col-md-6 text-center">

                <?= Asset::img(
                    'banner-image-bg-1.jpg',
                    array(
                        'class' => 'img-fluid rounded shadow',
                        'alt'   => 'Library Banner'
                    )
                ); ?>

            </div>

        </div>

    </div>

</section>

<!-- ================= FEATURES ================= -->

<section class="py-5">

    <div class="container">

        <div class="row text-center">

            <div class="col-md-4 mb-4">

                <div class="p-4 border rounded h-100">

                    <h4 class="mb-3">

                        Thousands of Books

                    </h4>

                    <p>

                        Explore books from many categories
                        and famous authors.

                    </p>

                </div>

            </div>

            <div class="col-md-4 mb-4">

                <div class="p-4 border rounded h-100">

                    <h4 class="mb-3">

                        Easy Borrow

                    </h4>

                    <p>

                        Borrow books quickly with a simple
                        online system.

                    </p>

                </div>

            </div>

            <div class="col-md-4 mb-4">

                <div class="p-4 border rounded h-100">

                    <h4 class="mb-3">

                        Modern Library

                    </h4>

                    <p>

                        Modern interface and easy
                        book management.

                    </p>

                </div>

            </div>

        </div>

    </div>

</section>

<!-- ================= BOOK LIST ================= -->

<section class="py-5 bg-light">

    <div class="container">

        <div class="row mb-5">

            <div class="col-md-12 text-center">

                <h2 class="fw-bold">

                    Latest Books

                </h2>

                <p>

                    Recently added books in the library

                </p>

            </div>

        </div>

        <div class="row">

            <?php if (!empty($books)): ?>

                <?php foreach ($books as $book): ?>

                    <?php

                    $image = !empty($book->image)
                        ? $book->image
                        : 'no-image.jpg';

                    ?>

                    <div class="col-lg-3 col-md-6 mb-4">

                        <div class="card border-0 shadow-sm h-100">

                            <div class="card-body">

                                <!-- BOOK IMAGE -->

                                <div class="text-center mb-3">

                                    <?= Asset::img(
                                        'books/' . $image,
                                        array(
                                            'class' => 'img-fluid rounded',
                                            'style' => '
                                                height:250px;
                                                width:100%;
                                                object-fit:cover;
                                            ',
                                            'alt' => $book->title
                                        )
                                    ); ?>

                                </div>

                                <!-- TITLE -->

                                <h5 class="card-title">

                                    <?= $book->title; ?>

                                </h5>

                                <!-- AUTHOR -->

                                <p class="mb-2 text">

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

                                <!-- AVAILABLE -->

                                <p class="mb-3">

                                    <strong>Available:</strong>

                                    <?= $book->available_copies; ?>

                                    /
                                    <?= $book->total_copies; ?>

                                </p>

                                <!-- BUTTON -->

                                <a href="/user/books/view/<?= $book->id; ?>"
                                   class="btn btn-outline-dark w-100">

                                    View Details

                                </a>

                            </div>

                        </div>

                    </div>

                <?php endforeach; ?>

            <?php else: ?>

                <div class="col-md-12 text-center">

                    <p>

                        No books found.

                    </p>

                </div>

            <?php endif; ?>

        </div>

    </div>

</section>