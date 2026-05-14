<section class="py-5 bg-white border-bottom border-dark border-2">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h1 class="display-3 fw-bold mb-4 text-black">Welcome to Library</h1>
                <p class="fs-4 text-black mb-4 fw-bold">
                    Explore our vast collection and borrow your favorite books today.
                </p>
            </div>
            <div class="col-md-6 text-center">
                <?= Asset::img('banner-image-bg-1.jpg', ['class' => 'img-fluid rounded shadow-lg border border-dark border-2']); ?>
            </div>
        </div>
    </div>
</section>

<section class="py-5 bg-white">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="display-5 fw-bold text-black">Our Book Collection</h2>
            <div class="bg-dark mx-auto" style="height: 6px; width: 100px;"></div>
        </div>

        <div class="row justify-content-center mb-5">
            <div class="col-lg-10">
                <form action="/user/books/index" method="get" class="input-group border border-dark border-2 rounded shadow-sm">
                    <input type="text" name="keyword" class="form-control border-0 p-3 fw-bold text-black" style="width: 80%"
                           placeholder="Search by title, ISBN, author..." 
                           value="<?= Input::get('keyword'); ?>">
                    <select name="search_by" style="width: 20%;float: right;" class="form-select border-dark border-2 border-top-0 border-end-0 rounded-0 bg-white fw-bold text-black">
                        <option value="title" <?= Input::get('search_by') == 'title' ? 'selected' : ''; ?>>By Title</option>
                        <option value="author" <?= Input::get('search_by') == 'author' ? 'selected' : ''; ?>>By Author</option>
                        <option value="isbn" <?= Input::get('search_by') == 'isbn' ? 'selected' : ''; ?>>By ISBN</option>
                    </select>
                    <button class="btn btn-dark px-4 fw-bold" type="submit">SEARCH</button>
                </form>
            </div>
        </div>

        <div class="row">
            <?php if (!empty($books)): ?>
                <?php foreach ($books as $book): ?>
                    <?php 
                        // Sửa lỗi truy cập Object sang Array []
                        $image = !empty($book['image']) ? $book['image'] : 'no-image.jpg'; 
                    ?>
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="card border border-dark border-2 h-100 shadow-sm book-card bg-white">
                            <div class="p-2">
                                <?= Asset::img('books/' . $image, [
                                    'class' => 'card-img-top rounded border border-dark',
                                    'style' => 'height: 320px; width: 100%; object-fit: cover;',
                                    'alt'   => $book['title']
                                ]); ?>
                            </div>
                            <div class="card-body d-flex flex-column pt-0">
                                <h5 class="fw-bold text-black mb-2" style="min-height: 3rem; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                                    <?= $book['title']; ?>
                                </h5>
                                <p class="text-black fw-bold mb-3">
                                    Author: <?= !empty($book['author']) ? $book['author']->name : 'Unknown'; ?>
                                </p>
                                
                                <div class="mt-auto pt-3 border-top border-dark border-2">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <span class="fw-bold text-black">In Stock: <?= $book['available_copies']; ?></span>
                                        <span class="badge bg-dark px-2 py-2"><?= $book['available_copies'] > 0 ? 'READY' : 'WAITLIST'; ?></span>
                                    </div>
                                    <a href="/user/books/view/<?= $book['id']; ?>" class="btn btn-dark w-100 fw-bold border-2">
                                        DETAILS
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12 text-center py-5">
                    <h3 class="text-black fw-bold">No results found for "<?= Input::get('keyword'); ?>"</h3>
                    <a href="/user/books" class="btn btn-dark mt-3 fw-bold">CLEAR SEARCH</a>
                </div>
            <?php endif; ?>
        </div>

        <?php if (isset($pagination) && !empty($pagination)): ?>
            <div class="row mt-5">
                <div class="col-12 d-flex justify-content-center">
                    <div class="pagination-wrapper">
                        <?php echo $pagination; ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</section>

<?= View::forge('user/partials/category_slider', [
    'title'       => 'Science & Technology',
    'subtitle'    => 'Explore the boundaries of human knowledge',
    'slider_id'   => 'science-slider',
    'data_books'  => $science_books
]); ?>

<?= View::forge('user/partials/category_slider', [
    'title'       => 'Literature & Fiction',
    'subtitle'    => 'Classic stories and modern masterpieces',
    'slider_id'   => 'fiction-slider',
    'data_books'  => $fiction_books
]); ?>

<style>
    .breadcrumb-item.active {
        color: #000 !important;
        font-weight: 800 !important;
        opacity: 1 !important;
    }
    
    .breadcrumb-item + .breadcrumb-item::before {
        color: #000 !important;
        font-weight: 900 !important;
        opacity: 1 !important;
        content: var(--bs-breadcrumb-divider, "/") !important;
    }

    .book-card {
        position: relative; /* Quan trọng: để định vị lớp giả bên trong */
        transition: all 0.1s ease;
        z-index: 1;
    }

    /* Lớp giả để giữ vùng tương tác (hitbox) */
    .book-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        z-index: -1;
        transition: all 0.1s ease;
    }

    .book-card:hover {
        transform: translateY(-20px);
        box-shadow: 0 20px 0px rgba(0, 0, 0, 1) !important;
    }

    .book-card:hover::before {
        bottom: -20px;
    }

    .pagination-wrapper .pagination span a {
        display: inline-block;
        padding: 10px 18px;
        border: 2px solid #000;
        margin: 0 3px;
        font-weight: 900;
        color: #000;
        text-decoration: none;
        background: #fff;
        transition: all 0.1s;
    }

    .pagination-wrapper .pagination span.active a {
        background: #000;
        color: #fff;
    }

    .pagination-wrapper .pagination span a:hover {
        background: #000;
        color: #fff;
        transform: translate(-2px, -2px);
        box-shadow: 2px 2px 0px #000;
    }

    .form-control::placeholder {
        color: #000;
        opacity: 0.7;
    }
</style>
<script>
    function scrollCategory(sliderId, direction) {
        const slider = document.getElementById(sliderId);
        const scrollAmount = 300; 
        if (direction === 'prev') {
            slider.scrollBy({ left: -scrollAmount, behavior: 'smooth' });
        } else {
            slider.scrollBy({ left: scrollAmount, behavior: 'smooth' });
        }
    }
</script>