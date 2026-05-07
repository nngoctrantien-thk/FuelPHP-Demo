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
						Create Book
					</h2>

					<a href="/admin/books"
						class="main-btn secondary-btn btn-hover">

						Back

					</a>

				</div>

				<!-- FORM -->

				<form method="post">

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
									class="form-control">

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
									class="form-control">

							</div>

						</div>

						<!-- IMAGE -->

						<div class="col-md-6">

							<div class="input-style-1">

								<label>
									Image
								</label>

								<input type="text"
									name="image"
									placeholder="book.jpg"
									class="form-control">

							</div>

						</div>

						<!-- AUTHOR -->

						<div class="col-md-6">

							<div class="select-style-1">

								<label>
									Author
								</label>

								<div class="select-position">

									<select name="author_id">

										<?php foreach ($authors as $author): ?>

											<option value="<?= $author->id; ?>">

												<?= $author->name; ?>

											</option>

										<?php endforeach; ?>

									</select>

								</div>

							</div>

						</div>

						<!-- CATEGORY -->

						<div class="col-md-6">

							<div class="select-style-1">

								<label>
									Category
								</label>

								<div class="select-position">

									<select name="category_id">

										<?php foreach ($categories as $category): ?>

											<option value="<?= $category->id; ?>">

												<?= $category->category_name; ?>

											</option>

										<?php endforeach; ?>

									</select>

								</div>

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
									class="form-control">

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
									class="form-control">

							</div>

						</div>

						<!-- BUTTON -->

						<div class="col-12 mt-3">

							<button type="submit"
								class="main-btn primary-btn btn-hover">

								Save Book

							</button>

						</div>

					</div>

				</form>

			</div>

		</div>

	</div>

</div>