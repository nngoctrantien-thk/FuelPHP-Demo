<div class="row">

    <div class="col-lg-12">

        <div class="card-style mb-30">

            <!-- HEADER -->

            <div class="d-flex
                        justify-content-between
                        align-items-center
                        flex-wrap
                        gap-3
                        mb-4">

                <div>

                    <h4 class="mb-2">
                        Books Management
                    </h4>

                    <p class="text-sm text-muted mb-0">
                        Manage all books in library
                    </p>

                </div>

                <a href="/admin/books/create"
                    class="main-btn primary-btn btn-hover">

                    <i class="lni lni-plus me-1"></i>

                    Create Book

                </a>

            </div>

            <!-- SEARCH -->

            <div class="search-card mb-4">

                <form method="get"
                    action="/admin/books/index">

                    <div class="row g-3 align-items-center">

                        <!-- KEYWORD -->

                        <div class="col-lg-5 col-md-12">

                            <input type="text"
                                name="keyword"
                                class="form-control search-input"
                                placeholder="Search books..."
                                value="<?= Input::get('keyword'); ?>">

                        </div>

                        <!-- SEARCH TYPE -->

                        <div class="col-lg-3 col-md-4">

                            <select name="search_by"
                                class="form-select search-select">

                                <option value="title"
                                    <?= Input::get('search_by') == 'title'
                                        ? 'selected'
                                        : ''; ?>>

                                    Search by Title

                                </option>

                                <option value="isbn"
                                    <?= Input::get('search_by') == 'isbn'
                                        ? 'selected'
                                        : ''; ?>>

                                    Search by ISBN

                                </option>

                                <option value="author"
                                    <?= Input::get('search_by') == 'author'
                                        ? 'selected'
                                        : ''; ?>>

                                    Search by Author

                                </option>

                                <option value="category"
                                    <?= Input::get('search_by') == 'category'
                                        ? 'selected'
                                        : ''; ?>>

                                    Search by Category

                                </option>

                            </select>

                        </div>

                        <!-- SEARCH BUTTON -->

                        <div class="col-lg-2 col-md-4">

                            <button type="submit"
                                class="main-btn primary-btn btn-hover w-100">

                                <i class="lni lni-search-alt"></i>

                                Search

                            </button>

                        </div>

                        <!-- RESET BUTTON -->

                        <div class="col-lg-2 col-md-4">

                            <a href="/admin/books"
                                class="main-btn light-btn w-100">

                                <i class="lni lni-reload"></i>

                                Reset

                            </a>

                        </div>

                    </div>

                </form>

            </div>

            <!-- FLASH MESSAGE -->

            <?= View::forge('admin/partials/flash'); ?>

            <!-- TABLE -->

            <div class="table-wrapper table-responsive">

                <table class="table align-middle">

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

                                        <strong>
                                            <?= $book['id']; ?>
                                        </strong>

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
                                                    border-radius:10px;
                                                    border:1px solid #e5e7eb;
                                                    box-shadow:0 2px 6px rgba(0,0,0,0.08);
                                                ',
                                                'alt' => $book['title']
                                            )
                                        ); ?>

                                    </td>

                                    <!-- TITLE -->

                                    <td class="min-width">

                                        <p class="fw-semibold mb-0">
                                            <?= $book['title']; ?>
                                        </p>

                                    </td>

                                    <!-- ISBN -->

                                    <td class="min-width">

                                        <p class="text-muted mb-0">
                                            <?= $book['isbn']; ?>
                                        </p>

                                    </td>

                                    <!-- AUTHOR -->

                                    <td class="min-width">

                                        <p class="mb-0">

                                            <?= !empty($book['author'])
                                                ? $book['author']->name
                                                : 'Unknown'; ?>

                                        </p>

                                    </td>

                                    <!-- CATEGORY -->

                                    <td class="min-width">

                                        <span class="px-3 py-2">

                                            <?= !empty($book['category'])
                                                ? $book['category']->category_name
                                                : 'Unknown'; ?>

                                        </span>

                                    </td>

                                    <!-- DESCRIPTION -->

                                    <td class="min-width">

                                        <?php
                                        $description = !empty($book['description'])
                                            ? strip_tags(html_entity_decode($book['description']))
                                            : 'No description';
                                        ?>

                                        <p
                                            class="text-muted mb-0"
                                            style="
                                            max-width:220px;
                                            white-space:nowrap;
                                            overflow:hidden;
                                            text-overflow:ellipsis;
                                        ">

                                            <?= Str::truncate($description, 80); ?>

                                        </p>

                                    </td>

                                    <!-- AVAILABLE -->

                                    <td class="min-width">

                                        <strong>

                                            <?= $book['available_copies']; ?>

                                            /

                                            <?= $book['total_copies']; ?>

                                        </strong>

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
                                                    justify-content-center
                                                    gap-3" style="gap: 1rem;">


                                            <a href="/admin/books/edit/<?= $book['id']; ?>"
                                                class="text-warning">

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
                                    class="text-center py-5">

                                    <div class="text-muted">

                                        No books found.

                                    </div>

                                </td>

                            </tr>

                        <?php endif; ?>

                    </tbody>

                </table>

            </div>

            <!-- PAGINATION -->

            <?php if (!empty($pagination)): ?>
                <div class="pagination-wrapper mt-4">
                    <?php echo $pagination; ?>
                </div>
            <?php endif; ?>

        </div>

    </div>

</div>
<style>
    .search-card {
        border-radius: 14px;
        padding: 20px;
    }

    .search-input,
    .search-select {

        height: 48px !important;

        border-radius: 10px;

        border: 1px solid #dce1eb;

        box-shadow: none;

        padding: 0 16px;

        font-size: 14px;
    }

    .search-select {

        appearance: auto;
    }

    .search-card .main-btn {

        height: 48px;

        display: flex;

        align-items: center;

        justify-content: center;

        gap: 6px;
    }

    .search-input:focus,
    .search-select:focus {

        border-color: #365CF5;

        box-shadow: 0 0 0 3px rgba(54, 92, 245, 0.12);
    }

    .table tbody tr {

        transition: all 0.2s ease;
    }

    .table tbody tr:hover {

        background: #fafbff;
    }

    .pagination-wrapper {

        display: flex;
        justify-content: center;
    }

    .pagination {

        margin: 0;
    }

    .pagination span {

        display: inline-block;
        margin: 0 4px;
    }

    .pagination span a {

        display: inline-block;

        min-width: 38px;
        height: 38px;
        line-height: 38px;

        padding: 0 14px;

        border: 1px solid #e5e7eb;
        border-radius: 8px;

        background: #fff;

        color: #333;

        font-size: 14px;
        font-weight: 500;

        text-decoration: none;

        transition: all 0.2s ease;
    }

    .pagination span a:hover {

        background: #365CF5;
        border-color: #365CF5;
        color: #fff;
    }

    .pagination .active a {

        background: #365CF5;
        border-color: #365CF5;
        color: #fff;
    }

    .pagination .previous-inactive a,
    .pagination .next-inactive a {

        background: #f5f5f5;
        color: #999;

        pointer-events: none;
        cursor: not-allowed;
    }
</style>