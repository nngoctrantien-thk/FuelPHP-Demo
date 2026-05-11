<div class="row">

    <div class="col-lg-12">

        <div class="card-style mb-30">

            <!-- HEADER -->

            <div class="d-flex
                        justify-content-between
                        align-items-center
                        mb-4">

                <div>

                    <h6 class="mb-10">

                        Books Management

                    </h6>

                    <p class="text-sm text-muted">

                        Manage all books in library

                    </p>

                </div>

                <a href="/admin/books/create"
                    class="main-btn primary-btn btn-hover">

                    Create Book

                </a>

            </div>

            <!-- FLASH MESSAGE -->

            <?= View::forge('admin/partials/flash'); ?>

            <!-- TABLE -->

            <div class="table-wrapper table-responsive">

                <table class="table">

                    <thead>

                        <tr>

                            <th>
                                <h6>#</h6>
                            </th>

                            <th>
                                <h6>Book</h6>
                            </th>

                            <th>
                                <h6>Title</h6>
                            </th>

                            <th>
                                <h6>ISBN</h6>
                            </th>

                            <th>
                                <h6>Author</h6>
                            </th>

                            <th>
                                <h6>Category</h6>
                            </th>

                            <th>
                                <h6>Description</h6>
                            </th>

                            <th>
                                <h6>Available</h6>
                            </th>

                            <th>
                                <h6>Status</h6>
                            </th>

                            <th class="text-center">
                                <h6>Action</h6>
                            </th>

                        </tr>

                    </thead>

                    <tbody>

                        <?php if (!empty($books)): ?>

                            <?php foreach ($books as $book): ?>

                                <?php

                                $image = !empty($book['image'])
                                    ? $book['image']
                                    : 'no-image.jpg';

                                ?>

                                <tr>

                                    <!-- ID -->

                                    <td>

                                        <p>

                                            <?= $book['id']; ?>

                                        </p>

                                    </td>

                                    <!-- IMAGE -->

                                    <td>

                                        <?= Asset::img(
                                            'books/' . $image,
                                            array(
                                                'style' => '
                                                    width:60px;
                                                    height:80px;
                                                    object-fit:cover;
                                                    border-radius:8px;
                                                    border:1px solid #ddd;
                                                ',
                                                'alt' => $book['title']
                                            )
                                        ); ?>

                                    </td>

                                    <!-- TITLE -->

                                    <td class="min-width">

                                        <p>

                                            <?= $book['title']; ?>

                                        </p>

                                    </td>

                                    <!-- ISBN -->

                                    <td class="min-width">

                                        <p>

                                            <?= $book['isbn']; ?>

                                        </p>

                                    </td>

                                    <!-- AUTHOR -->

                                    <td class="min-width">

                                        <p>

                                            <?=
                                            !empty($book['author'])
                                                ? $book['author']-> name
                                                : 'Unknown';
                                            ?>

                                        </p>

                                    </td>

                                    <!-- CATEGORY -->

                                    <td class="min-width">

                                        <p>

                                            <?=
                                            !empty($book['category'])
                                                ? $book['category']->category_name
                                                : 'Unknown';
                                            ?>

                                        </p>

                                    </td>

                                    <!-- DESCRIPTION -->

                                    <td class="min-width">

                                        <p style="
                                                max-width:220px;
                                                white-space:nowrap;
                                                overflow:hidden;
                                                text-overflow:ellipsis;
                                            ">

                                            <?= !empty($book['short_description'])
                                                ? $book['short_description']
                                                : 'No description'; ?>

                                        </p>

                                    </td>

                                    <!-- AVAILABLE -->

                                    <td class="min-width">

                                        <p>

                                            <?= $book['available_copies']; ?>

                                            /

                                            <?= $book['total_copies']; ?>

                                        </p>

                                    </td>

                                    <!-- STATUS -->

                                    <td class="min-width">

                                        <?php if ($book['available_copies'] > 0): ?>

                                            <span class="status-btn active-btn">

                                                Available

                                            </span>

                                        <?php else: ?>

                                            <span class="status-btn close-btn">

                                                Out Stock

                                            </span>

                                        <?php endif; ?>

                                    </td>

                                    <!-- ACTION -->

                                    <td>

                                        <div class="action
                                                    justify-content-center">

                                            <!-- VIEW -->

                                            <a href="/admin/books/view/<?= $book['id']; ?>"
                                                class="text-primary me-2">

                                                <i class="lni lni-eye"></i>

                                            </a>

                                            <!-- EDIT -->

                                            <a href="/admin/books/edit/<?= $book['id']; ?>"
                                                class="text-warning me-2">

                                                <i class="lni lni-pencil"></i>

                                            </a>

                                            <!-- DELETE -->

                                            <a href="/admin/books/delete/<?= $book['id']; ?>"
                                                class="text-danger"
                                                onclick="return confirm('Delete this book?')">

                                                <i class="lni lni-trash-can"></i>

                                            </a>

                                        </div>

                                    </td>

                                </tr>

                            <?php endforeach; ?>

                        <?php else: ?>

                            <tr>

                                <td colspan="10"
                                    class="text-center py-4">

                                    <div class="text-muted">

                                        No books found.

                                    </div>

                                </td>

                            </tr>

                        <?php endif; ?>

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>