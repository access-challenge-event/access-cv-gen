<!-- Job Listings Page -->
<section class="py-5">
    <div class="container">
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
            <div>
                <h1 class="mb-1">Job Listings</h1>
                <p class="text-muted mb-0">Sample listings pulled from the database.</p>
            </div>
            <a class="btn btn-outline-primary" href="<?php echo get_page_url('create'); ?>">Create CV</a>
        </div>

        <?php if (!empty($error)): ?>
            <div class="alert alert-warning" role="alert">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php elseif (empty($jobListings)): ?>
            <div class="alert alert-info" role="alert">
                No job listings found.
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-striped align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col">Title</th>
                            <th scope="col">Company</th>
                            <th scope="col">Location</th>
                            <th scope="col">Type</th>
                            <th scope="col">Level</th>
                            <th scope="col">Posted</th>
                            <th scope="col">Salary</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($jobListings as $job): ?>
                            <tr>
                                <td class="fw-semibold"><?php echo htmlspecialchars($job['title']); ?></td>
                                <td><?php echo htmlspecialchars($job['company']); ?></td>
                                <td><?php echo htmlspecialchars($job['location']); ?></td>
                                <td><?php echo htmlspecialchars($job['employment_type']); ?></td>
                                <td><?php echo htmlspecialchars($job['level']); ?></td>
                                <td><?php echo htmlspecialchars($job['posted_date']); ?></td>
                                <td><?php echo htmlspecialchars($job['salary_range'] ?? ''); ?></td>
                            </tr>
                            <tr class="table-light">
                                <td colspan="7">
                                    <div class="row g-3">
                                        <div class="col-lg-4">
                                            <h3 class="h6">Description</h3>
                                            <p class="mb-0 text-muted"><?php echo htmlspecialchars($job['description']); ?></p>
                                        </div>
                                        <div class="col-lg-4">
                                            <h3 class="h6">Responsibilities</h3>
                                            <ul class="mb-0">
                                                <?php
                                                $responsibilities = array_filter(array_map('trim', explode(';', $job['responsibilities'])));
                                                foreach ($responsibilities as $item):
                                                ?>
                                                    <li><?php echo htmlspecialchars($item); ?></li>
                                                <?php endforeach; ?>
                                            </ul>
                                        </div>
                                        <div class="col-lg-4">
                                            <h3 class="h6">Requirements</h3>
                                            <ul class="mb-0">
                                                <?php
                                                $requirements = array_filter(array_map('trim', explode(';', $job['requirements'])));
                                                foreach ($requirements as $item):
                                                ?>
                                                    <li><?php echo htmlspecialchars($item); ?></li>
                                                <?php endforeach; ?>
                                            </ul>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</section>
