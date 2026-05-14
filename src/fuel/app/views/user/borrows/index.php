<section class="py-5 bg-white border-bottom border-dark border-2">
    <div class="container">
        <div class="row mb-5">
            <div class="col-md-12 text-center">
                <h1 class="display-5 fw-bold text-black mb-2">My Borrowed Books</h1>
                <div class="bg-dark mx-auto mb-3" style="height: 5px; width: 80px;"></div>
                <p class="fs-5 text-black fw-bold">
                    List of books you are currently borrowing
                </p>
            </div>
        </div>

        <div class="row">
            <?php if (!empty($borrows)): ?>
                <?php foreach ($borrows as $borrow): ?>
                    <?php
                        $book = $borrow->book;
                        $image = !empty($book->image) ? $book->image : 'no-image.jpg';
                        $is_overdue = time() > $borrow->due_date;
                    ?>
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="card border border-dark border-2 shadow-sm h-100 borrow-card bg-white">
                            <div class="p-2 border-bottom border-dark border-2 bg-white">
                                <?= Asset::img('books/' . $image, [
                                    'class' => 'img-fluid rounded w-100',
                                    'style' => 'height: 350px; object-fit: cover;',
                                    'alt'   => $book->title
                                ]); ?>
                            </div>

                            <div class="card-body d-flex flex-column bg-white">
                                <h4 class="fw-bold text-black mb-3"><?= $book->title; ?></h4>
                                <div class="mb-4">
                                    <p class="mb-2 text-black"><span class="fw-bold">Author:</span> <?= !empty($book->author) ? $book->author->name : 'Unknown'; ?></p>
                                    <p class="mb-2 text-black"><span class="fw-bold">Borrow Date:</span> <?= date('d/m/Y', $borrow->borrowed_at); ?></p>
                                    <p class="mb-0 <?= $is_overdue ? 'text-danger' : 'text-black'; ?>">
                                        <span class="fw-bold">Due Date:</span> 
                                        <span class="<?= $is_overdue ? 'fw-extrabold border-bottom border-danger border-2' : ''; ?>">
                                            <?= date('d/m/Y', $borrow->due_date); ?>
                                        </span>
                                    </p>
                                </div>
                                <div class="mt-auto d-grid gap-2">
                                    <a href="/user/books/view/<?= $book->id; ?>" class="btn btn-outline-dark fw-bold border-2">View Details</a>
                                    <a href="/user/borrows/return/<?= $borrow->id; ?>" class="btn btn-dark fw-bold border-2" onclick="return confirm('Confirm return?')">Return Book</a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-md-12 text-center py-5">
                    <div class="border border-dark border-2 rounded p-5 bg-light">
                        <h3 class="fw-bold text-black">No active borrows</h3>
                        <a href="/user/books" class="btn btn-dark btn-lg fw-bold mt-3">Browse Books</a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php if (!empty($suggested_books)): ?>
<section class="py-5 bg-light border-top border-dark border-2">
    <div class="container">
        <div class="d-flex justify-content-between align-items-end mb-4">
            <div>
                <h2 class="fw-bold text-black mb-0">More from these Authors</h2>
                <p class="text-black fw-bold mb-0">Discover more works by authors you're currently reading</p>
            </div>
            <div class="d-flex gap-2">
                <button onclick="scrollSlide('prev')" class="btn-scroll">
                    <i class="lni lni-chevron-left"></i>
                </button>
                <button onclick="scrollSlide('next')" class="btn-scroll">
                    <i class="lni lni-chevron-right"></i>
                </button>
            </div>
        </div>

        <div id="suggested-slider" class="d-flex pb-4 gap-4 hide-scrollbar" style="overflow-x: auto; scroll-behavior: smooth; -webkit-overflow-scrolling: touch;">
            <?php foreach ($suggested_books as $s_book): ?>
                <?php 
                    $s_title = is_object($s_book) ? $s_book->title : $s_book['title'];
                    $s_id    = is_object($s_book) ? $s_book->id : $s_book['id'];
                    $s_img   = is_object($s_book) ? $s_book->image : $s_book['image'];
                    $s_author = is_object($s_book) ? $s_book->author->name : $s_book['author']->name;
                    $s_image = !empty($s_img) ? $s_img : 'no-image.jpg';
                ?>
                <div class="slide-item" style="min-width: 280px; max-width: 280px;">
                    <div class="card border border-dark border-2 h-100 bg-white shadow-sm hover-up">
                        <div class="p-2 border-bottom border-dark border-2 text-center bg-white">
                            <?= Asset::img('books/' . $s_image, [
                                'class' => 'img-fluid rounded',
                                'style' => 'height: 220px; object-fit: contain;',
                                'alt'   => $s_title
                            ]); ?>
                        </div>
                        <div class="card-body d-flex flex-column">
                            <h6 class="fw-bold text-black text-truncate mb-1"><?= $s_title; ?></h6>
                            <p class="text-black fw-bold mb-3 small">By <?= $s_author; ?></p>
                            <a href="/user/borrows/create/<?= $s_id; ?>" class="btn btn-dark btn-sm w-100 fw-bold border-2 mt-auto">
                                BORROW NOW
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>
<script>
function scrollSlide(direction) {
    const slider = document.getElementById('suggested-slider');
    const scrollAmount = 300 + 24;

    if (direction === 'next') {
        slider.scrollLeft += scrollAmount;
    } else {
        slider.scrollLeft -= scrollAmount;
    }
}
</script>
<style>
    .borrow-card, .hover-up { transition: all 0.3s ease; }
    .borrow-card:hover, .hover-up:hover {
        transform: translateY(-8px);
        box-shadow: 0px 8px 0px #000 !important;
    }
    .fw-extrabold { font-weight: 900; }
    .text-black { color: #000 !important; }
    
    .overflow-auto::-webkit-scrollbar { height: 8px; }
    .overflow-auto::-webkit-scrollbar-track { background: #eee; border-radius: 10px; }
    .overflow-auto::-webkit-scrollbar-thumb { background: #000; border-radius: 10px; }

    .btn-dark:hover {
        background-color: #000;
        transform: translateY(-2px);
        box-shadow: 0px 4px 0px #333;
    }
    .btn-scroll {
        width: 45px;
        height: 45px;
        background: #fff;
        border: 2px solid #000;
        color: #000;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 900;
        font-size: 20px;
        transition: all 0.1s;
        cursor: pointer;
    }

    .btn-scroll:hover {
        background: #000;
        color: #fff;
        transform: translate(-2px, -2px);
        box-shadow: 3px 3px 0px #000;
    }

    .btn-scroll:active {
        transform: translate(0, 0);
        box-shadow: 0px 0px 0px #000;
    }

    .hide-scrollbar::-webkit-scrollbar {
        display: none;
    }
    .hide-scrollbar {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }

    .text-black { color: #000 !important; }
</style>