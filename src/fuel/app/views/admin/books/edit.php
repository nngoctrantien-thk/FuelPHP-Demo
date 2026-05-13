<div class="container-fluid">

    <div class="row">

        <div class="col-lg-12 mx-auto">

            <div class="card-style mb-30">

                <!-- HEADER -->

                <div class="d-flex
                            justify-content-between
                            align-items-center
                            mb-4">

                    <h2 class="mb-0">

                        Edit Book

                    </h2>

                    <a href="/admin/books"
                        class="main-btn secondary-btn btn-hover">

                        Back

                    </a>

                </div>

                <!-- FLASH MESSAGE -->

                <?= View::forge('admin/partials/flash'); ?>

                <!-- FORM -->

                <form method="post"
                    enctype="multipart/form-data">

                    <div class="row">

                        <!-- TITLE -->

                        <div class="col-md-12">

                            <div class="input-style-1">

                                <label>

                                    Title

                                </label>

                                <input type="text"
                                    name="title"
                                    placeholder="Enter book title"
                                    value="<?= Input::post('title', $book->title); ?>"
                                    class="form-control <?= isset($errors['title']) ? 'is-invalid' : ''; ?>">

                                <?php if (isset($errors['title'])): ?>

                                    <div class="text-danger">

                                        <?= $errors['title']; ?>

                                    </div>

                                <?php endif; ?>

                            </div>

                        </div>

                        <!-- ISBN -->

                        <div class="col-md-6">

                            <div class="input-style-1">

                                <label>

                                    ISBN

                                </label>

                                <input type="text"
                                    name="isbn"
                                    placeholder="Enter ISBN"
                                    value="<?= Input::post('isbn', $book->isbn); ?>"
                                    class="form-control <?= isset($errors['isbn']) ? 'is-invalid' : ''; ?>">

                                <?php if (isset($errors['isbn'])): ?>

                                    <div class="text-danger">

                                        <?= $errors['isbn']; ?>

                                    </div>

                                <?php endif; ?>

                            </div>

                        </div>

                        <!-- IMAGE -->

                        <div class="col-md-6">

                            <div class="input-style-1">

                                <label>

                                    Image

                                </label>

                                <input type="file"
                                    name="image"
                                    accept=".jpg,.jpeg,.png,.webp"
                                    class="<?= isset($errors['image']) ? 'is-invalid' : ''; ?>">

                                <?php if (!empty($book->image)): ?>

                                    <div class="mt-3">

                                        <img src="/assets/img/books/<?= $book->image; ?>"
                                            width="100"
                                            height="140"
                                            style="
                                                border-radius:10px;
                                                object-fit:cover;
                                                border:1px solid #ddd;
                                             ">

                                    </div>

                                <?php endif; ?>

                                <?php if (isset($errors['image'])): ?>

                                    <div class="text-danger">

                                        <?= $errors['image']; ?>

                                    </div>

                                <?php endif; ?>

                            </div>

                        </div>

                        <!-- DESCRIPTION -->

                        <div class="col-md-12">

                            <div class="input-style-1">

                                <label>

                                    Description

                                </label>

                                <textarea
                                    id="description"
                                    name="description"
                                    rows="5"
                                    placeholder="Enter book description"
                                    class="form-control <?= isset($errors['description']) ? 'is-invalid' : ''; ?>"><?= Input::post(
                                                                                                                        'description',
                                                                                                                        $book->description
                                                                                                                    ); ?></textarea>

                                <?php if (isset($errors['description'])): ?>

                                    <div class="text-danger">

                                        <?= $errors['description']; ?>

                                    </div>

                                <?php endif; ?>

                            </div>

                        </div>

                        <!-- AUTHOR -->

                        <div class="col-md-6">

                            <div class="select-style-1">

                                <label>

                                    Author

                                </label>

                                <div class="select-position">

                                    <select name="author_id"
                                        class="<?= isset($errors['author_id']) ? 'is-invalid' : ''; ?>">

                                        <option value="">

                                            Select Author

                                        </option>

                                        <?php foreach ($authors as $author): ?>

                                            <option value="<?= $author->id; ?>"
                                                <?= Input::post(
                                                    'author_id',
                                                    $book->author_id
                                                ) == $author->id
                                                    ? 'selected'
                                                    : ''; ?>>

                                                <?= $author->name; ?>

                                            </option>

                                        <?php endforeach; ?>

                                    </select>

                                </div>

                                <?php if (isset($errors['author_id'])): ?>

                                    <div class="text-danger">

                                        <?= $errors['author_id']; ?>

                                    </div>

                                <?php endif; ?>

                            </div>

                        </div>

                        <!-- CATEGORY -->

                        <div class="col-md-6">

                            <div class="select-style-1">

                                <label>

                                    Category

                                </label>

                                <div class="select-position">

                                    <select name="category_id"
                                        class="<?= isset($errors['category_id']) ? 'is-invalid' : ''; ?>">

                                        <option value="">

                                            Select Category

                                        </option>

                                        <?php foreach ($categories as $category): ?>

                                            <option value="<?= $category->id; ?>"
                                                <?= Input::post(
                                                    'category_id',
                                                    $book->category_id
                                                ) == $category->id
                                                    ? 'selected'
                                                    : ''; ?>>

                                                <?= $category->category_name; ?>

                                            </option>

                                        <?php endforeach; ?>

                                    </select>

                                </div>

                                <?php if (isset($errors['category_id'])): ?>

                                    <div class="text-danger">

                                        <?= $errors['category_id']; ?>

                                    </div>

                                <?php endif; ?>

                            </div>

                        </div>

                        <!-- TOTAL COPIES -->

                        <div class="col-md-6">

                            <div class="input-style-1">

                                <label>

                                    Total Copies

                                </label>

                                <input type="number"
                                    name="total_copies"
                                    placeholder="0"
                                    value="<?= Input::post('total_copies', $book->total_copies); ?>"
                                    class="form-control <?= isset($errors['total_copies']) ? 'is-invalid' : ''; ?>">

                                <?php if (isset($errors['total_copies'])): ?>

                                    <div class="text-danger">

                                        <?= $errors['total_copies']; ?>

                                    </div>

                                <?php endif; ?>

                            </div>

                        </div>

                        <!-- AVAILABLE COPIES -->

                        <div class="col-md-6">

                            <div class="input-style-1">

                                <label>

                                    Available Copies

                                </label>

                                <input type="number"
                                    name="available_copies"
                                    placeholder="0"
                                    value="<?= Input::post('available_copies', $book->available_copies); ?>"
                                    class="form-control <?= isset($errors['available_copies']) ? 'is-invalid' : ''; ?>">

                                <?php if (isset($errors['available_copies'])): ?>

                                    <div class="text-danger">

                                        <?= $errors['available_copies']; ?>

                                    </div>

                                <?php endif; ?>

                            </div>

                        </div>

                        <!-- BUTTON -->

                        <div class="col-12 mt-4">

                            <button type="submit"
                                class="main-btn primary-btn btn-hover">

                                Update Book

                            </button>

                        </div>

                    </div>

                </form>

            </div>

        </div>

    </div>

</div>