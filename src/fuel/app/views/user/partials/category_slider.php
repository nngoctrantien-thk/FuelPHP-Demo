<?php if (!empty($data_books)): ?>
<section class="py-5 bg-white border-top border-dark border-2">
    <div class="container">
        <div class="d-flex justify-content-between align-items-end mb-4">
            <div>
                <h2 class="fw-bold text-black mb-0"><?= $title; ?></h2>
                <p class="text-black fw-bold mb-0 opacity-75"><?= $subtitle; ?></p>
            </div>
            <div class="d-flex gap-2">
                <button onclick="scrollCategory('<?= $slider_id; ?>', 'prev')" class="btn-scroll">
                    <i class="lni lni-chevron-left"></i>
                </button>
                <button onclick="scrollCategory('<?= $slider_id; ?>', 'next')" class="btn-scroll">
                    <i class="lni lni-chevron-right"></i>
                </button>
            </div>
        </div>

        <div id="<?= $slider_id; ?>" class="d-flex pb-4 gap-4 hide-scrollbar" 
             style="overflow-x: auto; scroll-behavior: smooth; -webkit-overflow-scrolling: touch;">
            
            <?php foreach ($data_books as $c_book): ?>
                <?php 
                    $c_title = is_object($c_book) ? $c_book->title : $c_book['title'];
                    $c_id    = is_object($c_book) ? $c_book->id : $c_book['id'];
                    $c_img   = is_object($c_book) ? $c_book->image : $c_book['image'];
                    $c_author = is_object($c_book) ? $c_book->author->name : $c_book['author']->name;
                    $c_image = !empty($c_img) ? $c_img : 'no-image.jpg';
                ?>
                <div class="slide-item" style="min-width: 260px; max-width: 260px;">
                    <div class="card border border-dark border-2 h-100 bg-white shadow-sm book-card">
                        <div class="p-2 border-bottom border-dark border-2 text-center bg-white">
                            <?= Asset::img('books/' . $c_image, [
                                'class' => 'img-fluid rounded',
                                'style' => 'height: 200px; width: 100%; object-fit: cover;',
                                'alt'   => $c_title
                            ]); ?>
                        </div>
                        <div class="card-body d-flex flex-column pt-3">
                            <h6 class="fw-bold text-black text-truncate mb-1"><?= $c_title; ?></h6>
                            <p class="text-black fw-bold mb-3 small opacity-75">By <?= $c_author; ?></p>
                            <a href="/user/books/view/<?= $c_id; ?>" class="btn btn-dark btn-sm w-100 fw-bold border-2 mt-auto">
                                VIEW DETAILS
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>