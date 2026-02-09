<!-- Create CV Page -->
<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <h1 class="mb-4">Create a New CV</h1>
                
                <div class="card">
                    <div class="card-body">
                        <form>
                            <div class="mb-3">
                                <label for="fullName" class="form-label">Full Name</label>
                                <input type="text" class="form-control" id="fullName" placeholder="John Doe" required>
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" placeholder="john@example.com" required>
                            </div>

                            <div class="mb-3">
                                <label for="phone" class="form-label">Phone</label>
                                <input type="tel" class="form-control" id="phone" placeholder="+1 (555) 123-4567">
                            </div>

                            <div class="mb-3">
                                <label for="summary" class="form-label">Professional Summary</label>
                                <textarea class="form-control" id="summary" rows="4" placeholder="Tell us about yourself..."></textarea>
                            </div>

                <!-- Generate CV Section -->
                <div class="card mt-4">
                    <div class="card-body">
                        <h5 class="card-title">Generate Your CV</h5>
                        <p class="card-text text-muted">Once you've filled in your details above, select a job to tailor your CV for and generate it.</p>
                        <form method="POST" action="" id="generateCvForm">
                            <input type="hidden" name="action" value="generate_cv">

                            <!-- User Profile Data -->
                            <input type="hidden" name="name" value="<?php echo htmlspecialchars(($user['firstname'] ?? '') . ' ' . ($user['lastname'] ?? '')); ?>">
                            <input type="hidden" name="email" value="<?php echo htmlspecialchars($user['email'] ?? ''); ?>">
                            <input type="hidden" name="summary" value="<?php echo htmlspecialchars($user['about'] ?? ''); ?>">

                            <!-- Education Data -->
                            <?php foreach ($education as $i => $edu): ?>
                                <input type="hidden" name="education[<?php echo $i; ?>][institution]" value="<?php echo htmlspecialchars($edu['school']); ?>">
                                <input type="hidden" name="education[<?php echo $i; ?>][degree]" value="<?php echo htmlspecialchars($edu['title']); ?>">
                                <input type="hidden" name="education[<?php echo $i; ?>][field]" value="">
                                <input type="hidden" name="education[<?php echo $i; ?>][graduation_date]" value="<?php echo date('Y', strtotime($edu['graduation_date'])); ?>">
                            <?php endforeach; ?>

                            <!-- Experience Data -->
                            <?php foreach ($experience as $i => $exp): ?>
                                <input type="hidden" name="experience[<?php echo $i; ?>][job_title]" value="<?php echo htmlspecialchars($exp['job_title']); ?>">
                                <input type="hidden" name="experience[<?php echo $i; ?>][company]" value="<?php echo htmlspecialchars($exp['location']); ?>">
                                <input type="hidden" name="experience[<?php echo $i; ?>][start_date]" value="">
                                <input type="hidden" name="experience[<?php echo $i; ?>][end_date]" value="<?php echo htmlspecialchars($exp['duration']); ?>">
                                <input type="hidden" name="experience[<?php echo $i; ?>][description]" value="<?php echo htmlspecialchars($exp['content']); ?>">
                            <?php endforeach; ?>

                            <!-- Awards Data -->
                            <?php foreach ($awards as $i => $award): ?>
                                <input type="hidden" name="awards[<?php echo $i; ?>][title]" value="<?php echo htmlspecialchars($award['title']); ?>">
                                <input type="hidden" name="awards[<?php echo $i; ?>][description]" value="<?php echo htmlspecialchars($award['description']); ?>">
                            <?php endforeach; ?>

                            <div class="row g-3">
                                <div class="col-md-8">
                                    <label for="job_target" class="form-label">Target Job (Optional)</label>
                                    <select class="form-select" id="job_target" name="job_id">
                                        <option value="">-- Select a job to tailor your CV --</option>
                                        <?php foreach ($jobListings as $job): ?>
                                            <option value="<?php echo $job['job_id']; ?>">
                                                <?php echo htmlspecialchars($job['title'] . ' at ' . $job['company']); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-4 d-flex align-items-end">
                                    <button type="submit" class="btn btn-primary btn-lg w-100">Generate CV</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
