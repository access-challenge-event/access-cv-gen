<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <h1 class="display-5 fw-bold mb-2">Add New Job</h1>
    </div>
</section>

<section class="py-5">
    <div class="container" style="max-width: 720px;">

        <!-- Job Details -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Job Details</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="/staff/jobs">
                    <input type="hidden" name="action" value="add_job">

                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" class="form-control" id="title" name="title"
                               value="<?= htmlspecialchars($user['title'] ?? '') ?>" maxlength="48" required>
                    </div>

                    <div class="mb-3">
                        <label for="employment_type" class="form-label">Employment Type</label>
                        <input type="employment_type" class="form-control" id="employment_type" name="employment_type"
                               value="<?= htmlspecialchars($user['employment_type'] ?? '') ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="level" class="form-label">Level</label>
                        <input type="text" class="form-control" id="level" name="level"
                               value="<?= htmlspecialchars($user['level'] ?? '') ?>" maxlength="48" required>
                    </div>

                    <div class="mb-3">
                        <label for="location" class="form-label">Location</label>
                        <input type="text" class="form-control" id="location" name="location"
                               value="<?= htmlspecialchars($user['location'] ?? '') ?>" maxlength="48" required>
                    </div>

                    <div class="mb-3">
                        <label for="requirements" class="form-label">Requirements</label>
                        <input type="text" class="form-control" id="requirements" name="requirements"
                               value="<?= htmlspecialchars($user['requirements'] ?? '') ?>" maxlength="48" required>
                    </div>

                    <div class="mb-3">
                        <label for="responsibilities" class="form-label">Responsibilities</label>
                        <input type="text" class="form-control" id="responsibilities" name="responsibilities"
                               value="<?= htmlspecialchars($user['responsibilities'] ?? '') ?>" maxlength="48" required>
                    </div>

                    <div class="mb-3">
                        <label for="salary_range" class="form-label">Salary Range</label>
                        <input type="text" class="form-control" id="salary_range" name="salary_range"
                               value="<?= htmlspecialchars($user['salary_range'] ?? '') ?>" maxlength="48">
                    </div>

                    <button type="submit" class="btn btn-primary">Add Job</button>
                </form>
            </div>
        </div>
    </div>
</section>
