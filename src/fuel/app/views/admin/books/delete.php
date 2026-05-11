<div class="container-fluid">

    <div class="row">

        <div class="col-lg-8 mx-auto">

            <div class="card-style mb-30">

                <!-- HEADER -->

                <div class="d-flex
                            justify-content-between
                            align-items-center
                            mb-4">

                    <h2 class="mb-0 text-danger">
                        Delete Book
                    </h2>

                    <a href="/admin/books"
                       class="main-btn secondary-btn btn-hover">

                        Back

                    </a>

                </div>

                <!-- CONTENT -->

                <div class="mb-4 text-center">

                    <?php if (!empty($book->image)): ?>

                        <img src="/assets/img/books/<?= $book->image; ?>"
                             width="120"
                             style="
                                height:160px;
                                object-fit:cover;
                                border-radius:10px;
                             ">

                    <?php endif; ?>

                </div>

                <table class="table table-bordered">

                    <tr>
                        <th width="200">Title</th>
                        <td><?= $book->title; ?></td>
                    </tr>

                    <tr>
                        <th>ISBN</th>
                        <td><?= $book->isbn; ?></td>
                    </tr>

                    <tr>
                        <th>Author</th>
                        <td>
                            <?= !empty($book->author)
                                ? $book->author->name
                                : 'Unknown'; ?>
                        </td>
                    </tr>

                    <tr>
                        <th>Category</th>
                        <td>
                            <?= !empty($book->category)
                                ? $book->category->category_name
                                : 'Unknown'; ?>
                        </td>
                    </tr>

                    <tr>
                        <th>Total Copies</th>
                        <td><?= $book->total_copies; ?></td>
                    </tr>

                    <tr>
                        <th>Available Copies</th>
                        <td><?= $book->available_copies; ?></td>
                    </tr>

                </table>

                <!-- WARNING -->

                <div class="alert alert-danger mt-4">

                    Are you sure you want to delete this book?

                </div>

                <!-- FORM -->

                <form method="post">

                    <button type="submit"
                            class="main-btn danger-btn btn-hover">

                        Confirm Delete

                    </button>

                </form>

            </div>

        </div>

    </div>

</div>