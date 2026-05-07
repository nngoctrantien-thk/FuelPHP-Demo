<div class="title-wrapper pt-30 mb-4">
    <div class="row align-items-center">

        <div class="col-md-6">
            <div class="title">
                <h2>Library Dashboard</h2>
            </div>
        </div>

        <div class="col-md-6">
            <div class="breadcrumb-wrapper">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-end">

                        <li class="breadcrumb-item">
                            <a href="/admin">
                                Dashboard
                            </a>
                        </li>

                        <li class="breadcrumb-item active" aria-current="page">
                            Home
                        </li>

                    </ol>
                </nav>
            </div>
        </div>

    </div>
</div>

<!-- Dashboard Cards -->
<div class="row">

    <!-- Books -->
    <div class="col-xl-3 col-lg-3 col-sm-6">

        <div class="icon-card mb-30">

            <div class="icon purple">
                <i class="lni lni-book"></i>
            </div>

            <div class="content">

                <h6 class="mb-10">
                    Total Books
                </h6>

                <h3 class="text-bold mb-10">
                    <?= isset($total_books) ? $total_books : 0; ?>
                </h3>

                <a href="/admin/books"
                   class="main-btn primary-btn btn-hover btn-sm">
                    Manage
                </a>

            </div>

        </div>

    </div>

    <!-- Authors -->
    <div class="col-xl-3 col-lg-3 col-sm-6">

        <div class="icon-card mb-30">

            <div class="icon success">
                <i class="lni lni-pencil-alt"></i>
            </div>

            <div class="content">

                <h6 class="mb-10">
                    Authors
                </h6>

                <h3 class="text-bold mb-10">
                    <?= isset($total_authors) ? $total_authors : 0; ?>
                </h3>

                <a href="/admin/authors"
                   class="main-btn success-btn btn-hover btn-sm">
                    Manage
                </a>

            </div>

        </div>

    </div>

    <!-- Categories -->
    <div class="col-xl-3 col-lg-3 col-sm-6">

        <div class="icon-card mb-30">

            <div class="icon orange">
                <i class="lni lni-grid-alt"></i>
            </div>

            <div class="content">

                <h6 class="mb-10">
                    Categories
                </h6>

                <h3 class="text-bold mb-10">
                    <?= isset($total_categories) ? $total_categories : 0; ?>
                </h3>

                <a href="/admin/categories"
                   class="main-btn warning-btn btn-hover btn-sm">
                    Manage
                </a>

            </div>

        </div>

    </div>

    <!-- Borrow -->
    <div class="col-xl-3 col-lg-3 col-sm-6">

        <div class="icon-card mb-30">

            <div class="icon primary">
                <i class="lni lni-agenda"></i>
            </div>

            <div class="content">

                <h6 class="mb-10">
                    Borrowing
                </h6>

                <h3 class="text-bold mb-10">
                    <?= isset($total_borrows) ? $total_borrows : 0; ?>
                </h3>

                <a href="/admin/borrows"
                   class="main-btn primary-btn btn-hover btn-sm">
                    Manage
                </a>

            </div>

        </div>

    </div>

</div>

<!-- Welcome Card -->
<div class="row">

    <div class="col-lg-12">

        <div class="card-style mb-30">

            <div class="d-flex justify-content-between align-items-center mb-3">

                <div>
                    <h4 class="mb-2">
                        Welcome,
                        <?= \Auth::get_screen_name(); ?>
                    </h4>

                    <p>
                        Library Management System Admin Dashboard
                    </p>
                </div>

            </div>

            <hr>

            <div class="row mt-4">

                <div class="col-md-3 mb-3">

                    <a href="/admin/books/create"
                       class="main-btn primary-btn btn-hover w-100">

                        Add Book

                    </a>

                </div>

                <div class="col-md-3 mb-3">

                    <a href="/admin/authors/create"
                       class="main-btn success-btn btn-hover w-100">

                        Add Author

                    </a>

                </div>

                <div class="col-md-3 mb-3">

                    <a href="/admin/categories/create"
                       class="main-btn warning-btn btn-hover w-100">

                        Add Category

                    </a>

                </div>

                <div class="col-md-3 mb-3">

                    <a href="/admin/borrows"
                       class="main-btn dark-btn btn-hover w-100">

                        View Borrow

                    </a>

                </div>

            </div>

        </div>

    </div>

</div>

<!-- Recent Activity -->
<div class="row">

    <div class="col-lg-12">

        <div class="card-style mb-30">

            <div class="title d-flex flex-wrap align-items-center justify-content-between">

                <div class="left">

                    <h6 class="text-medium mb-30">
                        Recent Books
                    </h6>

                </div>

            </div>

            <div class="table-responsive">

                <table class="table top-selling-table">

                    <thead>

                        <tr>

                            <th>
                                <h6 class="text-sm text-medium">
                                    ID
                                </h6>
                            </th>

                            <th>
                                <h6 class="text-sm text-medium">
                                    Title
                                </h6>
                            </th>

                            <th>
                                <h6 class="text-sm text-medium">
                                    ISBN
                                </h6>
                            </th>

                            <th>
                                <h6 class="text-sm text-medium">
                                    Total
                                </h6>
                            </th>

                        </tr>

                    </thead>

                    <tbody>

                    <?php if (!empty($books)): ?>

                        <?php foreach ($books as $book): ?>

                            <tr>

                                <td>
                                    <?= $book->id; ?>
                                </td>

                                <td>
                                    <?= $book->title; ?>
                                </td>

                                <td>
                                    <?= $book->isbn; ?>
                                </td>

                                <td>
                                    <?= $book->total_copies; ?>
                                </td>

                            </tr>

                        <?php endforeach; ?>

                    <?php else: ?>

                        <tr>

                            <td colspan="4">
                                No books found.
                            </td>

                        </tr>

                    <?php endif; ?>

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>