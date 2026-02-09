<!-- Create CV Page -->
<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-10 mx-auto">
                <h1 class="mb-4">Create Your CV</h1>
                <p class="text-muted mb-4">Fill in your details below. Your information will be saved and used to generate tailored CVs.</p>

                <?php if (!empty($message)): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <?php echo htmlspecialchars($message); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <?php if (!empty($error)): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?php echo htmlspecialchars($error); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <div class="accordion" id="cvAccordion">
                    <!-- Profile Section -->
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#profileSection">
                                Personal Information
                            </button>
                        </h2>
                        <div id="profileSection" class="accordion-collapse collapse show" data-bs-parent="#cvAccordion">
                            <div class="accordion-body">
                                <form method="POST" action="/app/create">
                                    <input type="hidden" name="action" value="update_profile">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label for="firstname" class="form-label">First Name</label>
                                            <input type="text" class="form-control" id="firstname" name="firstname"
                                                   value="<?php echo htmlspecialchars($user['firstname'] ?? ''); ?>" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="lastname" class="form-label">Last Name</label>
                                            <input type="text" class="form-control" id="lastname" name="lastname"
                                                   value="<?php echo htmlspecialchars($user['lastname'] ?? ''); ?>" required>
                                        </div>
                                        <div class="col-12">
                                            <label for="email_display" class="form-label">Email</label>
                                            <input type="email" class="form-control" id="email_display"
                                                   value="<?php echo htmlspecialchars($user['email'] ?? ''); ?>" disabled>
                                            <div class="form-text">Email cannot be changed.</div>
                                        </div>
                                        <div class="col-12">
                                            <label for="about" class="form-label">About / Professional Summary</label>
                                            <textarea class="form-control" id="about" name="about" rows="4"
                                                      placeholder="Brief professional summary about yourself..."><?php echo htmlspecialchars($user['about'] ?? ''); ?></textarea>
                                        </div>
                                        <div class="col-12">
                                            <button type="submit" class="btn btn-primary">Save Profile</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Education Section -->
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#educationSection">
                                Education (<?php echo count($education ?? []); ?>)
                            </button>
                        </h2>
                        <div id="educationSection" class="accordion-collapse collapse" data-bs-parent="#cvAccordion">
                            <div class="accordion-body">
                                <?php if (!empty($education)): ?>
                                    <div class="mb-4">
                                        <?php foreach ($education as $edu): ?>
                                            <div class="card mb-2">
                                                <div class="card-body d-flex justify-content-between align-items-start">
                                                    <div>
                                                        <h6 class="mb-1"><?php echo htmlspecialchars($edu['title']); ?></h6>
                                                        <p class="mb-1 text-muted"><?php echo htmlspecialchars($edu['school']); ?></p>
                                                        <small class="text-muted">
                                                            <?php echo $edu['length']; ?> years |
                                                            Graduated: <?php echo date('M Y', strtotime($edu['graduation_date'])); ?>
                                                        </small>
                                                    </div>
                                                    <form method="POST" action="/app/create" class="ms-2">
                                                        <input type="hidden" name="action" value="delete_education">
                                                        <input type="hidden" name="education_id" value="<?php echo $edu['education_id']; ?>">
                                                        <button type="submit" class="btn btn-sm btn-outline-danger"
                                                                onclick="return confirm('Delete this education entry?')">Delete</button>
                                                    </form>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>

                                <h6 class="mb-3">Add Education</h6>
                                <form method="POST" action="/app/create">
                                    <input type="hidden" name="action" value="add_education">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label for="edu_title" class="form-label">Degree / Qualification</label>
                                            <input type="text" class="form-control" id="edu_title" name="title"
                                                   placeholder="e.g., Bachelor of Science" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="edu_school" class="form-label">School / Institution</label>
                                            <input type="text" class="form-control" id="edu_school" name="school"
                                                   placeholder="e.g., University of Example" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="edu_length" class="form-label">Duration (years)</label>
                                            <input type="number" class="form-control" id="edu_length" name="length"
                                                   min="1" max="10" value="4" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="edu_graduation" class="form-label">Graduation Date</label>
                                            <input type="date" class="form-control" id="edu_graduation" name="graduation_date" required>
                                        </div>
                                        <div class="col-12">
                                            <button type="submit" class="btn btn-success">Add Education</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Experience Section -->
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#experienceSection">
                                Work Experience (<?php echo count($experience ?? []); ?>)
                            </button>
                        </h2>
                        <div id="experienceSection" class="accordion-collapse collapse" data-bs-parent="#cvAccordion">
                            <div class="accordion-body">
                                <?php if (!empty($experience)): ?>
                                    <div class="mb-4">
                                        <?php foreach ($experience as $exp): ?>
                                            <div class="card mb-2">
                                                <div class="card-body d-flex justify-content-between align-items-start">
                                                    <div>
                                                        <h6 class="mb-1"><?php echo htmlspecialchars($exp['job_title']); ?></h6>
                                                        <p class="mb-1 text-muted"><?php echo htmlspecialchars($exp['location']); ?> | <?php echo htmlspecialchars($exp['duration']); ?></p>
                                                        <small class="text-muted"><?php echo htmlspecialchars($exp['content']); ?></small>
                                                    </div>
                                                    <form method="POST" action="/app/create" class="ms-2">
                                                        <input type="hidden" name="action" value="delete_experience">
                                                        <input type="hidden" name="experience_id" value="<?php echo $exp['experience_id']; ?>">
                                                        <button type="submit" class="btn btn-sm btn-outline-danger"
                                                                onclick="return confirm('Delete this experience entry?')">Delete</button>
                                                    </form>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>

                                <h6 class="mb-3">Add Experience</h6>
                                <form method="POST" action="/app/create">
                                    <input type="hidden" name="action" value="add_experience">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label for="exp_title" class="form-label">Job Title</label>
                                            <input type="text" class="form-control" id="exp_title" name="job_title"
                                                   placeholder="e.g., Software Developer" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="exp_location" class="form-label">Company / Location</label>
                                            <input type="text" class="form-control" id="exp_location" name="location"
                                                   placeholder="e.g., Tech Corp, London" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="exp_duration" class="form-label">Duration</label>
                                            <input type="text" class="form-control" id="exp_duration" name="duration"
                                                   placeholder="e.g., Jan 2020 - Present" required>
                                        </div>
                                        <div class="col-12">
                                            <label for="exp_content" class="form-label">Description / Responsibilities</label>
                                            <textarea class="form-control" id="exp_content" name="content" rows="3"
                                                      placeholder="Describe your role and key achievements..." required></textarea>
                                        </div>
                                        <div class="col-12">
                                            <button type="submit" class="btn btn-success">Add Experience</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Awards Section -->
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#awardsSection">
                                Awards & Achievements (<?php echo count($awards ?? []); ?>)
                            </button>
                        </h2>
                        <div id="awardsSection" class="accordion-collapse collapse" data-bs-parent="#cvAccordion">
                            <div class="accordion-body">
                                <?php if (!empty($awards)): ?>
                                    <div class="mb-4">
                                        <?php foreach ($awards as $award): ?>
                                            <div class="card mb-2">
                                                <div class="card-body d-flex justify-content-between align-items-start">
                                                    <div>
                                                        <h6 class="mb-1"><?php echo htmlspecialchars($award['title']); ?></h6>
                                                        <small class="text-muted"><?php echo htmlspecialchars($award['description']); ?></small>
                                                    </div>
                                                    <form method="POST" action="/app/create" class="ms-2">
                                                        <input type="hidden" name="action" value="delete_award">
                                                        <input type="hidden" name="award_id" value="<?php echo $award['award_id']; ?>">
                                                        <button type="submit" class="btn btn-sm btn-outline-danger"
                                                                onclick="return confirm('Delete this award?')">Delete</button>
                                                    </form>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>

                                <h6 class="mb-3">Add Award</h6>
                                <form method="POST" action="/app/create">
                                    <input type="hidden" name="action" value="add_award">
                                    <div class="row g-3">
                                        <div class="col-12">
                                            <label for="award_title" class="form-label">Award Title</label>
                                            <input type="text" class="form-control" id="award_title" name="title"
                                                   placeholder="e.g., Employee of the Year" required>
                                        </div>
                                        <div class="col-12">
                                            <label for="award_desc" class="form-label">Description</label>
                                            <textarea class="form-control" id="award_desc" name="description" rows="2"
                                                      placeholder="Brief description of the award..." required></textarea>
                                        </div>
                                        <div class="col-12">
                                            <button type="submit" class="btn btn-success">Add Award</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Generate CV Section -->
                <div class="card mt-4">
                    <div class="card-body">
                        <h5 class="card-title">Generate Your CV</h5>
                        <p class="card-text text-muted">Once you've filled in your details above, select a job to tailor your CV for and generate it.</p>
                        <form method="POST" action="" id="generateCvForm">
                            <input type="hidden" name="action" value="generate_cv">

                            <!-- User Profile Data -->
                            <input type="hidden" name="name" value="<?php echo htmlspecialchars(trim(($user['firstname'] ?? '') . ' ' . ($user['lastname'] ?? ''))); ?>">
                            <input type="hidden" name="email" value="<?php echo htmlspecialchars($user['email'] ?? ''); ?>">
                            <input type="hidden" name="summary" value="<?php echo htmlspecialchars($user['about'] ?? ''); ?>">

                            <!-- Education Data -->
                            <?php if (!empty($education)): ?>
                                <?php foreach ($education as $i => $edu): ?>
                                    <input type="hidden" name="education[<?php echo $i; ?>][institution]" value="<?php echo htmlspecialchars($edu['school']); ?>">
                                    <input type="hidden" name="education[<?php echo $i; ?>][degree]" value="<?php echo htmlspecialchars($edu['title']); ?>">
                                    <input type="hidden" name="education[<?php echo $i; ?>][field]" value="">
                                    <input type="hidden" name="education[<?php echo $i; ?>][graduation_date]" value="<?php echo date('Y', strtotime($edu['graduation_date'])); ?>">
                                <?php endforeach; ?>
                            <?php endif; ?>

                            <!-- Experience Data -->
                            <?php if (!empty($experience)): ?>
                                <?php foreach ($experience as $i => $exp): ?>
                                    <input type="hidden" name="experience[<?php echo $i; ?>][job_title]" value="<?php echo htmlspecialchars($exp['job_title']); ?>">
                                    <input type="hidden" name="experience[<?php echo $i; ?>][company]" value="<?php echo htmlspecialchars($exp['location']); ?>">
                                    <input type="hidden" name="experience[<?php echo $i; ?>][start_date]" value="">
                                    <input type="hidden" name="experience[<?php echo $i; ?>][end_date]" value="<?php echo htmlspecialchars($exp['duration']); ?>">
                                    <input type="hidden" name="experience[<?php echo $i; ?>][description]" value="<?php echo htmlspecialchars($exp['content']); ?>">
                                <?php endforeach; ?>
                            <?php endif; ?>

                            <!-- Awards Data -->
                            <?php if (!empty($awards)): ?>
                                <?php foreach ($awards as $i => $award): ?>
                                    <input type="hidden" name="awards[<?php echo $i; ?>][title]" value="<?php echo htmlspecialchars($award['title']); ?>">
                                    <input type="hidden" name="awards[<?php echo $i; ?>][description]" value="<?php echo htmlspecialchars($award['description']); ?>">
                                <?php endforeach; ?>
                            <?php endif; ?>

                            <div class="row g-3">
                                <div class="col-md-8">
                                    <label for="job_target" class="form-label">Target Job (Optional)</label>
                                    <select class="form-select" id="job_target" name="job_id">
                                        <option value="">-- Select a job to tailor your CV --</option>
                                        <?php if (!empty($jobListings)): ?>
                                            <?php foreach ($jobListings as $job): ?>
                                                <option value="<?php echo $job['job_id']; ?>">
                                                    <?php echo htmlspecialchars($job['title'] . ' at ' . $job['company']); ?>
                                                </option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                                <div class="col-md-4 d-flex align-items-end">
                                    <button type="submit" class="btn btn-primary btn-lg w-100">Generate CV</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="mt-3">
                    <a href="<?php echo get_page_url('home'); ?>" class="btn btn-secondary">Back to Home</a>
                </div>
            </div>
        </div>
    </div>
</section>
