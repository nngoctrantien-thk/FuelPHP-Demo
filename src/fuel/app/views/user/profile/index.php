<div class="container py-5">
    <div class="row">
        <div class="col-lg-4">
            <div class="card mb-4 shadow-sm">
                <div class="card-body text-center">
                    <img src="https://ui-avatars.com/api/?name=<?= urlencode($user->username); ?>&size=150&background=0D6EFD&color=fff" 
                         alt="avatar" class="rounded-circle img-fluid" style="width: 150px;">
                    <h5 class="my-3"><?= $user->username; ?></h5>
                    <p class="text-muted mb-1"><?= ($user->group == 100) ? 'Administrator' : 'Member'; ?></p>
                    <p class="text-muted mb-4">Joined: <?= date('d/m/Y', $user->created_at); ?></p>
                    <div class="d-flex justify-content-center mb-2">
                        <span class="badge <?= $user->is_active ? 'bg-success' : 'bg-secondary'; ?>">
                            <?= $user->is_active ? 'Active Account' : 'Inactive'; ?>
                        </span>
                    </div>
                </div>
            </div>

            <div class="card mb-4 mb-lg-0 shadow-sm">
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush rounded-3">
                        <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                            <i class="bi bi-book text-primary"></i>
                            <p class="mb-0">Total Borrows: <strong><?= count($user->borrows); ?></strong></p>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                            <i class="bi bi-clock-history text-warning"></i>
                            <p class="mb-0">Last Login: <?= $user->last_login ? date('H:i d/m/Y', $user->last_login) : 'Never'; ?></p>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card mb-4 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0"><i class="bi bi-person-lines-fill me-2"></i>Account Settings</h5>
                </div>
                <div class="card-body">
                    <?php echo Form::open(array('action' => 'user/update_profile', 'class' => 'row g-3')); ?>
                        
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Username</label>
                            <input type="text" class="form-control bg-light" value="<?= $user->username; ?>" readonly>
                            <div class="form-text">Username cannot be changed.</div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold">Email Address</label>
                            <input type="email" name="email" class="form-control" value="<?= $user->email; ?>" required>
                        </div>

                        <div class="col-md-12">
                            <hr class="my-3">
                            <h6 class="text-primary">Personal Details</h6>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold">Full Name</label>
                            <input type="text" name="full_name" class="form-control" placeholder="Enter your full name">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold">Phone Number</label>
                            <input type="text" name="phone" class="form-control" placeholder="Enter phone number">
                        </div>

                        <div class="col-12 mt-4 text-end">
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="bi bi-save me-1"></i> Save Changes
                            </button>
                        </div>

                    <?php echo Form::close(); ?>
                </div>
            </div>

            <div class="card shadow-sm border-danger-subtle">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-1 fw-bold text-danger">Security</h6>
                        <p class="text-muted mb-0 small">Keep your account secure by updating your password regularly.</p>
                    </div>
                    <a href="<?= Uri::create('user/change_password'); ?>" class="btn btn-outline-danger btn-sm">
                        Change Password
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>