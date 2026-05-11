<!-- ================= BOOK DETAIL ================= -->

<section class="py-5 bg-light">

    <div class="container">

        <div class="row">

            <div class="col-lg-10 mx-auto">

                <div class="card border-0 shadow-sm">

                    <div class="row g-0">

                        <?php

                        $image = !empty($book->image)
                            ? $book->image
                            : 'no-image.jpg';

                        ?>

                        <!-- BOOK IMAGE -->

                        <div class="col-md-5">

                            <?= Asset::img(
                                'books/' . $image,
                                array(
                                    'class' => 'img-fluid w-100 h-100 rounded-start',
                                    'style' => '
                                        object-fit: cover;
                                        min-height: 500px;
                                    ',
                                    'alt' => $book->title
                                )
                            ); ?>

                        </div>

                        <!-- BOOK INFO -->

                        <div class="col-md-7">

                            <div class="card-body p-5">

                                <!-- TITLE -->

                                <h1 class="fw-bold mb-3">

                                    <?= $book->title; ?>

                                </h1>

                                <!-- AUTHOR -->

                                <p class="mb-3 fs-5">

                                    <strong>Author:</strong>

                                    <?=
                                    !empty($book->author)
                                        ? $book->author->name
                                        : 'Unknown Author';
                                    ?>

                                </p>

                                <!-- ISBN -->

                                <p class="mb-3">

                                    <strong>ISBN:</strong>

                                    <?= $book->isbn; ?>

                                </p>

                                <!-- CATEGORY -->

                                <p class="mb-3">

                                    <strong>Category:</strong>

                                    <?=
                                    !empty($book->category)
                                        ? $book->category->category_name
                                        : 'No Category';
                                    ?>

                                </p>

                                <!-- TOTAL COPIES -->

                                <p class="mb-3">

                                    <strong>Total Copies:</strong>

                                    <?= $book->total_copies; ?>

                                </p>

                                <!-- AVAILABLE COPIES -->

                                <p class="mb-4">

                                    <strong>Available Copies:</strong>

                                    <?= $book->available_copies; ?>

                                </p>

                                <!-- DESCRIPTION -->

                                <div class="mb-4">

                                    <h5 class="fw-bold mb-3">

                                        Description

                                    </h5>

                                    <p class="text-danger">

                                        <?= !empty($book->description)
                                            ? nl2br($book->description)
                                            : 'No description available.';
                                        ?>

                                    </p>

                                </div>

                                <!-- ACTION BUTTONS -->

                                <div class="d-flex gap-3">

                                    <a href="/user/books"
                                        class="btn btn-outline-secondary">

                                        Back to Books

                                    </a>

                                    <?php if ($book->available_copies > 0): ?>

                                        <a href="/user/borrows/create/<?= $book->id; ?>"
                                            class="btn btn-dark">

                                            Borrow Book

                                        </a>

                                    <?php else: ?>

                                        <button class="btn btn-secondary" disabled>

                                            Out of Stock

                                        </button>

                                    <?php endif; ?>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</section>