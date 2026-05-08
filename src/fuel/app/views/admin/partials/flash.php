<?php if (Session::get_flash('success')): ?>

    <div class="alert alert-success mb-4">

        <?= Session::get_flash('success'); ?>

    </div>

<?php endif; ?>


<?php if (Session::get_flash('error')): ?>

    <div class="alert alert-danger mb-4">

        <?= Session::get_flash('error'); ?>

    </div>

<?php endif; ?>


<?php if (Session::get_flash('errors')): ?>

    <div class="alert alert-danger mb-4">

        <ul class="mb-0">

            <?php foreach (Session::get_flash('errors') as $error): ?>

                <li>

                    <?= $error; ?>

                </li>

            <?php endforeach; ?>

        </ul>

    </div>

<?php endif; ?>