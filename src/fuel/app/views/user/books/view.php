<?php
$image_name   = !empty($book->image) ? $book->image : 'no-image.jpg';
$author_name  = !empty($book->author) ? $book->author->name : 'Unknown Author';
$category_name = !empty($book->category) ? $book->category->category_name : 'General';
$description  = !empty($book->description)
    ? html_entity_decode($book->description)
    : 'No description available for this book.';
?>

<section class="py-5 bg-white min-vh-100">
    <div class="container">
        <div class="row">
            <div class="col-lg-10 mx-auto">

                <nav aria-label="breadcrumb" class="mb-4">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/user" class="text-dark fw-bold">Library</a></li>
                        <li class="breadcrumb-item active text-dark fw-bold"><?= $book->title; ?></li>
                    </ol>
                </nav>

                <div class="card border-0 shadow-lg overflow-hidden">
                    <div class="row g-0">
                        <div class="col-md-5 bg-white d-flex align-items-center justify-content-center p-3 border-end">
                            <?= Asset::img('books/' . $image_name, [
                                'class' => 'img-fluid rounded shadow',
                                'style' => 'max-height: 600px; width: 100%; object-fit: contain;',
                                'alt'   => $book->title
                            ]); ?>
                        </div>

                        <div class="col-md-7">
                            <div class="card-body p-lg-5 p-4 bg-white">
                                <span class="badge bg-dark mb-3 px-3 py-2 rounded-pill">
                                    <?= $category_name; ?>
                                </span>

                                <h1 class="display-5 fw-bold mb-4 text-black">
                                    <?= $book->title; ?>
                                </h1>

                                <div class="mb-4 pb-4 border-bottom">
                                    <p class="mb-2 fs-5 text-black">
                                        <span class="fw-bold">Author:</span> <?= $author_name; ?>
                                    </p>
                                    <p class="mb-0 text-black fw-bold">
                                        ISBN: <?= $book->isbn; ?>
                                    </p>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-6">
                                        <div class="p-3 border border-dark rounded text-center bg-light">
                                            <span class="d-block fw-bold text-black mb-1">Total Copies</span>
                                            <span class="h4 fw-bold text-black"><?= $book->total_copies; ?></span>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="p-3 border border-dark rounded text-center <?= $book->available_copies > 0 ? 'bg-success bg-opacity-10' : 'bg-danger bg-opacity-10'; ?>">
                                            <span class="d-block fw-bold text-black mb-1">Available</span>
                                            <span class="h4 fw-bold <?= $book->available_copies > 0 ? 'text-success' : 'text-danger'; ?>">
                                                <?= $book->available_copies; ?>
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-5">
                                    <h5 class="fw-bold mb-3 text-black border-bottom pb-2">Description</h5>
                                    <div class="text-black fs-5 lh-base">
                                        <?= $description; ?>
                                    </div>
                                </div>

                                <div class="d-flex flex-wrap gap-3">
                                    <a href="/user/books" class="btn btn-outline-dark btn-lg px-4 fw-bold">
                                        Back to Library
                                    </a>
                                    <?php if ($book->available_copies > 0): ?>
                                        <a href="/user/borrows/create/<?= $book->id; ?>" class="btn btn-dark btn-lg px-5 flex-grow-1 fw-bold shadow">
                                            Borrow Now
                                        </a>
                                    <?php else: ?>
                                        <button class="btn btn-secondary btn-lg px-5 flex-grow-1 fw-bold" disabled>
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
<style>
    .breadcrumb-item+.breadcrumb-item::before {
        color: #000 !important;
        font-weight: 900 !important;
        opacity: 1 !important;
    }
</style>