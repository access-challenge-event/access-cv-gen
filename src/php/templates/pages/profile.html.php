<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <h1 class="display-5 fw-bold mb-2">My Profile</h1>
        <p class="lead mb-0">View and update your personal details.</p>
    </div>
</section>

<section class="py-5">
    <div class="container" style="max-width: 720px;">

        <?php if (!empty($message)): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= htmlspecialchars($message) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?php if (!empty($error)): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= htmlspecialchars($error) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <!-- Profile Details -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Profile Details</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="/app/profile">
                    <input type="hidden" name="action" value="update_profile">

                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username"
                               value="<?= htmlspecialchars($user['username'] ?? '') ?>" maxlength="24" required>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="firstname" class="form-label">First Name</label>
                            <input type="text" class="form-control" id="firstname" name="firstname"
                                   value="<?= htmlspecialchars($user['firstname'] ?? '') ?>" maxlength="24">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="lastname" class="form-label">Last Name</label>
                            <input type="text" class="form-control" id="lastname" name="lastname"
                                   value="<?= htmlspecialchars($user['lastname'] ?? '') ?>" maxlength="24">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email"
                               value="<?= htmlspecialchars($user['email'] ?? '') ?>" disabled>
                        <div class="form-text">Email cannot be changed.</div>
                    </div>

                    <div class="mb-3">
                        <label for="age" class="form-label">Date of Birth</label>
                        <input type="date" class="form-control" id="age" name="age"
                               value="<?= htmlspecialchars($user['age'] ?? '') ?>">
                    </div>

                    <div class="mb-3">
                        <label for="about" class="form-label">About Me</label>
                        <textarea class="form-control" id="about" name="about" rows="4"
                                  maxlength="512"><?= htmlspecialchars($user['about'] ?? '') ?></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </form>
            </div>
        </div>

        <!-- Change Password -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Change Password</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="/app/profile">
                    <input type="hidden" name="action" value="change_password">

                    <div class="mb-3">
                        <label for="current_password" class="form-label">Current Password</label>
                        <input type="password" class="form-control" id="current_password" name="current_password" required>
                    </div>

                    <div class="mb-3">
                        <label for="new_password" class="form-label">New Password</label>
                        <input type="password" class="form-control" id="new_password" name="new_password" required minlength="6">
                    </div>

                    <div class="mb-3">
                        <label for="confirm_password" class="form-label">Confirm New Password</label>
                        <input type="password" class="form-control" id="confirm_password" name="confirm_password" required minlength="6">
                    </div>

                    <button type="submit" class="btn btn-warning">Change Password</button>
                </form>
            </div>
        </div>

        <!-- Account Info -->
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Account Info</h5>
            </div>
            <div class="card-body">
                <p class="mb-1"><strong>Member since:</strong> <?= htmlspecialchars($user['date_created'] ?? 'N/A') ?></p>
                <p class="mb-0"><strong>Last updated:</strong> <?= htmlspecialchars($user['date_updated'] ?? 'N/A') ?></p>
            </div>
        </div>

    </div>
</section>
