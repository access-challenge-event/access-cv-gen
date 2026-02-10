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
                                                    <button type="button" class="btn btn-sm btn-outline-danger ms-2"
                                                            onclick="showDeleteModal('delete_education', 'education_id', '<?php echo $edu['education_id']; ?>', '<?php echo htmlspecialchars($edu['title']); ?>')">Delete</button>
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
                                                    <button type="button" class="btn btn-sm btn-outline-danger ms-2"
                                                            onclick="showDeleteModal('delete_experience', 'experience_id', '<?php echo $exp['experience_id']; ?>', '<?php echo htmlspecialchars($exp['job_title']); ?>')">Delete</button>
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
                                                    <button type="button" class="btn btn-sm btn-outline-danger ms-2"
                                                            onclick="showDeleteModal('delete_award', 'award_id', '<?php echo $award['award_id']; ?>', '<?php echo htmlspecialchars($award['title']); ?>')">Delete</button>
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

                    <!-- Upload Existing CV Section -->
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#uploadCvSection">
                                Upload Existing CV (Optional)
                            </button>
                        </h2>
                        <div id="uploadCvSection" class="accordion-collapse collapse" data-bs-parent="#cvAccordion">
                            <div class="accordion-body">
                                <p class="text-muted mb-3">Upload an existing CV as a PDF to use as additional context when generating your new CV, or to get feedback on your current CV.</p>

                                <div class="row g-3">
                                    <div class="col-md-8">
                                        <label for="cv_upload" class="form-label">Select PDF File</label>
                                        <input type="file" class="form-control" id="cv_upload" accept=".pdf">
                                        <div class="form-text">Maximum file size: 5MB</div>
                                    </div>
                                    <div class="col-md-4 d-flex align-items-end">
                                        <button type="button" class="btn btn-outline-secondary w-100" id="gradeCvBtn" disabled>
                                            <span class="btn-text">Grade My CV</span>
                                            <span class="btn-loading" style="display:none;">
                                                <span class="spinner-border spinner-border-sm me-2" role="status"></span>
                                                Grading...
                                            </span>
                                        </button>
                                    </div>
                                </div>

                                <div id="cv-upload-status" class="mt-3" style="display:none;">
                                    <div class="alert alert-info mb-0">
                                        <div class="d-flex align-items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="me-2" viewBox="0 0 16 16">
                                                <path d="M14 4.5V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h5.5L14 4.5zM10 4a1 1 0 0 1-1-1V1.5L14 6h-3a1 1 0 0 1-1-1z"/>
                                            </svg>
                                            <div>
                                                <strong id="cv-upload-filename"></strong>
                                                <span class="text-muted ms-2" id="cv-upload-chars"></span>
                                            </div>
                                            <button type="button" class="btn btn-sm btn-outline-danger ms-auto" id="clearUploadBtn">Clear</button>
                                        </div>
                                    </div>
                                </div>

                                <div id="cv-upload-error" class="alert alert-danger mt-3" style="display:none;"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Generate CV Section -->
                <div class="card mt-4">
                    <div class="card-body">
                        <h5 class="card-title">Generate Your CV</h5>
                        <p class="card-text text-muted">Once you've filled in your details above, select a job to tailor your CV for and generate it.</p>

                        <div id="generate-cv-error" class="alert alert-danger" style="display:none;"></div>

                        <form method="POST" action="" id="generateCvForm">
                            <input type="hidden" name="action" value="generate_cv">

                            <!-- User Profile Data -->
                            <input type="hidden" name="name" value="<?php echo htmlspecialchars(trim(($user['firstname'] ?? '') . ' ' . ($user['lastname'] ?? ''))); ?>">
                            <input type="hidden" name="email" value="<?php echo htmlspecialchars($user['email'] ?? ''); ?>">
                            <input type="hidden" name="summary" value="<?php echo htmlspecialchars($user['about'] ?? ''); ?>">

                            <!-- Uploaded CV Text (populated by JavaScript) -->
                            <input type="hidden" name="existing_cv" id="existing_cv_text" value="">

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
                                <div class="col-md-5">
                                    <label for="job_target" class="form-label">Target Job (Optional)</label>
                                    <select class="form-select" id="job_target" name="job_id">
                                        <option value="" data-title="">-- Select a job to tailor your CV --</option>
                                        <?php if (!empty($jobListings)): ?>
                                            <?php foreach ($jobListings as $job): ?>
                                                <option value="<?php echo $job['job_id']; ?>" data-title="<?php echo htmlspecialchars($job['title'] . ' at ' . $job['company']); ?>">
                                                    <?php echo htmlspecialchars($job['title'] . ' at ' . $job['company']); ?>
                                                </option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="ai_model" class="form-label">AI Model</label>
                                    <select class="form-select" id="ai_model" name="ai_model">
                                        <option value="deepseek" selected>DeepSeek</option>
                                        <option value="gemini" disabled>Gemini (Coming Soon)</option>
                                        <option value="gpt" disabled>GPT (Coming Soon)</option>
                                    </select>
                                </div>
                                <div class="col-md-4 d-flex align-items-end">
                                    <button type="submit" class="btn btn-primary btn-lg w-100" id="generateCvBtn">
                                        <span class="btn-text">Generate CV</span>
                                        <span class="btn-loading" style="display:none;">
                                            <span class="spinner-border spinner-border-sm me-2" role="status"></span>
                                            Generating...
                                        </span>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirm Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete <strong id="deleteItemName"></strong>?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form method="POST" action="/app/create" id="deleteForm" class="d-inline">
                    <input type="hidden" name="action" id="deleteAction">
                    <input type="hidden" name="" id="deleteIdField">
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function showDeleteModal(action, idName, idValue, itemName) {
    document.getElementById('deleteAction').value = action;
    var idField = document.getElementById('deleteIdField');
    idField.name = idName;
    idField.value = idValue;
    document.getElementById('deleteItemName').textContent = itemName;
    new bootstrap.Modal(document.getElementById('deleteModal')).show();
}
</script>

<script>
(function() {
    var form = document.getElementById('generateCvForm');
    var btn = document.getElementById('generateCvBtn');
    var errorEl = document.getElementById('generate-cv-error');

    function setLoading(loading) {
        btn.disabled = loading;
        btn.querySelector('.btn-text').style.display = loading ? 'none' : '';
        btn.querySelector('.btn-loading').style.display = loading ? 'inline' : 'none';
    }

    function showError(message) {
        errorEl.textContent = message;
        errorEl.style.display = '';
    }

    function hideError() {
        errorEl.style.display = 'none';
    }

    function collectFormData() {
        var data = {
            name: form.querySelector('input[name="name"]').value,
            email: form.querySelector('input[name="email"]').value,
            summary: form.querySelector('input[name="summary"]').value,
            existing_cv: document.getElementById('existing_cv_text').value,
            education: [],
            experience: [],
            awards: [],
            job_target: ''
        };

        // Get selected job target
        var jobSelect = document.getElementById('job_target');
        var selectedOption = jobSelect.options[jobSelect.selectedIndex];
        if (selectedOption && selectedOption.dataset.title) {
            data.job_target = selectedOption.dataset.title;
        }

        // Collect education entries
        var eduInputs = form.querySelectorAll('input[name^="education["]');
        var eduMap = {};
        eduInputs.forEach(function(input) {
            var match = input.name.match(/education\[(\d+)\]\[(\w+)\]/);
            if (match) {
                var idx = match[1];
                var field = match[2];
                if (!eduMap[idx]) eduMap[idx] = {};
                eduMap[idx][field] = input.value;
            }
        });
        Object.keys(eduMap).forEach(function(k) {
            data.education.push(eduMap[k]);
        });

        // Collect experience entries
        var expInputs = form.querySelectorAll('input[name^="experience["]');
        var expMap = {};
        expInputs.forEach(function(input) {
            var match = input.name.match(/experience\[(\d+)\]\[(\w+)\]/);
            if (match) {
                var idx = match[1];
                var field = match[2];
                if (!expMap[idx]) expMap[idx] = {};
                expMap[idx][field] = input.value;
            }
        });
        Object.keys(expMap).forEach(function(k) {
            data.experience.push(expMap[k]);
        });

        // Collect awards entries
        var awardInputs = form.querySelectorAll('input[name^="awards["]');
        var awardMap = {};
        awardInputs.forEach(function(input) {
            var match = input.name.match(/awards\[(\d+)\]\[(\w+)\]/);
            if (match) {
                var idx = match[1];
                var field = match[2];
                if (!awardMap[idx]) awardMap[idx] = {};
                awardMap[idx][field] = input.value;
            }
        });
        Object.keys(awardMap).forEach(function(k) {
            data.awards.push(awardMap[k]);
        });

        return data;
    }

    form.addEventListener('submit', function(e) {
        e.preventDefault();
        hideError();

        var data = collectFormData();

        // Validate required fields
        if (!data.name || !data.name.trim()) {
            showError('Please fill in your name in the Personal Information section.');
            return;
        }
        if (!data.email || !data.email.trim()) {
            showError('Email is required.');
            return;
        }

        setLoading(true);

        fetch('/api/router.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ action: 'generate_cv', data: data })
        })
        .then(function(res) { return res.json(); })
        .then(function(json) {
            if (json && json.success && json.result && json.result.content) {
                // Save the CV to database with grading
                var jobSelect = document.getElementById('job_target');
                var jobId = jobSelect.value || 0;

                return fetch('/api/router.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({
                        action: 'save_cv',
                        data: {
                            cv_content: json.result.content,
                            job_target: data.job_target,
                            job_id: jobId,
                            grade_cv: true
                        }
                    })
                })
                .then(function(res) { return res.json(); })
                .then(function(saveJson) {
                    setLoading(false);
                    if (saveJson && saveJson.success && saveJson.result) {
                        // Redirect to view page with cv_id
                        window.location.href = '/app/viewCv?id=' + saveJson.result.cv_id;
                    } else {
                        // Still show the CV even if save failed
                        sessionStorage.setItem('generatedCV', json.result.content);
                        sessionStorage.setItem('generatedCVName', data.name);
                        window.location.href = '/app/viewCv';
                    }
                });
            } else if (json && json.error) {
                setLoading(false);
                showError(json.error + (json.detail ? ': ' + json.detail : ''));
            } else {
                setLoading(false);
                showError('Unexpected response from server.');
            }
        })
        .catch(function(err) {
            setLoading(false);
            showError('Network or server error. Please try again.');
            console.error(err);
        });
    });
})();
</script>

<!-- CV Grade Modal -->
<div class="modal fade" id="gradeModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <h5 class="modal-title mb-1">CV Assessment</h5>
                    <small class="text-muted" id="grade-modal-filename"></small>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="grade-loading" class="text-center py-4">
                    <div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div>
                    <p class="mt-2 text-muted mb-0">Analyzing your CV...</p>
                </div>
                <div id="grade-content" style="display:none;"></div>
                <div id="grade-error" class="alert alert-danger" style="display:none;"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- PDF.js Library -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>
<script>
// Set PDF.js worker
pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js';

(function() {
    var cvUpload = document.getElementById('cv_upload');
    var gradeCvBtn = document.getElementById('gradeCvBtn');
    var uploadStatus = document.getElementById('cv-upload-status');
    var uploadFilename = document.getElementById('cv-upload-filename');
    var uploadChars = document.getElementById('cv-upload-chars');
    var uploadError = document.getElementById('cv-upload-error');
    var clearUploadBtn = document.getElementById('clearUploadBtn');
    var existingCvText = document.getElementById('existing_cv_text');

    var extractedText = '';
    var currentFilename = '';

    function showUploadError(message) {
        uploadError.textContent = message;
        uploadError.style.display = '';
    }

    function hideUploadError() {
        uploadError.style.display = 'none';
    }

    function setGradeLoading(loading) {
        gradeCvBtn.disabled = loading || !extractedText;
        gradeCvBtn.querySelector('.btn-text').style.display = loading ? 'none' : '';
        gradeCvBtn.querySelector('.btn-loading').style.display = loading ? 'inline' : 'none';
    }

    async function extractTextFromPdf(file) {
        var arrayBuffer = await file.arrayBuffer();
        var pdf = await pdfjsLib.getDocument({ data: arrayBuffer }).promise;
        var textParts = [];

        for (var i = 1; i <= pdf.numPages; i++) {
            var page = await pdf.getPage(i);
            var textContent = await page.getTextContent();
            var pageText = textContent.items.map(function(item) {
                return item.str;
            }).join(' ');
            textParts.push(pageText);
        }

        return textParts.join('\n\n');
    }

    cvUpload.addEventListener('change', async function(e) {
        var file = e.target.files[0];
        if (!file) return;

        hideUploadError();

        // Validate file type
        if (file.type !== 'application/pdf') {
            showUploadError('Please upload a PDF file.');
            cvUpload.value = '';
            return;
        }

        // Validate file size (5MB max)
        if (file.size > 5 * 1024 * 1024) {
            showUploadError('File size must be less than 5MB.');
            cvUpload.value = '';
            return;
        }

        try {
            gradeCvBtn.disabled = true;
            uploadStatus.style.display = 'none';

            extractedText = await extractTextFromPdf(file);
            currentFilename = file.name;

            if (!extractedText.trim()) {
                showUploadError('Could not extract text from the PDF. The file may be image-based or empty.');
                extractedText = '';
                gradeCvBtn.disabled = true;
                return;
            }

            // Update UI
            uploadFilename.textContent = file.name;
            uploadChars.textContent = '(' + extractedText.length + ' characters extracted)';
            uploadStatus.style.display = '';
            gradeCvBtn.disabled = false;

            // Store in hidden field for generate CV
            existingCvText.value = extractedText;

        } catch (err) {
            console.error('PDF extraction error:', err);
            showUploadError('Error reading PDF file. Please try another file.');
            extractedText = '';
            gradeCvBtn.disabled = true;
        }
    });

    clearUploadBtn.addEventListener('click', function() {
        cvUpload.value = '';
        extractedText = '';
        currentFilename = '';
        existingCvText.value = '';
        uploadStatus.style.display = 'none';
        gradeCvBtn.disabled = true;
        hideUploadError();
    });

    // Grade CV functionality
    gradeCvBtn.addEventListener('click', function() {
        if (!extractedText) return;

        var modal = new bootstrap.Modal(document.getElementById('gradeModal'));
        var loading = document.getElementById('grade-loading');
        var content = document.getElementById('grade-content');
        var errorEl = document.getElementById('grade-error');
        var filenameEl = document.getElementById('grade-modal-filename');

        loading.style.display = '';
        content.style.display = 'none';
        errorEl.style.display = 'none';
        filenameEl.textContent = currentFilename;

        modal.show();
        setGradeLoading(true);

        // Get selected job target for context
        var jobSelect = document.getElementById('job_target');
        var selectedOption = jobSelect.options[jobSelect.selectedIndex];
        var jobTitle = selectedOption && selectedOption.dataset.title ? selectedOption.dataset.title : '';

        fetch('/api/router.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                action: 'grade_cv',
                data: {
                    cv_text: extractedText,
                    job_title: jobTitle
                }
            })
        })
        .then(function(res) { return res.json(); })
        .then(function(json) {
            setGradeLoading(false);
            loading.style.display = 'none';

            if (json && json.success && json.result && json.result.grade) {
                content.style.display = '';
                renderGradeResults(content, json.result.grade);
            } else if (json && json.error) {
                errorEl.style.display = '';
                errorEl.textContent = json.error + (json.detail ? ': ' + json.detail : '');
            } else {
                errorEl.style.display = '';
                errorEl.textContent = 'Unexpected response from server.';
            }
        })
        .catch(function(err) {
            setGradeLoading(false);
            loading.style.display = 'none';
            errorEl.style.display = '';
            errorEl.textContent = 'Network or server error.';
            console.error(err);
        });
    });

    function escapeHtml(text) {
        var div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    function getScoreColor(score, max) {
        var pct = (score / max) * 100;
        if (pct >= 70) return 'success';
        if (pct >= 50) return 'warning';
        return 'danger';
    }

    function renderGradeResults(container, grade) {
        var html = [];

        // Overall Score
        var overallColor = getScoreColor(grade.overall_score, 100);
        html.push('<div class="text-center mb-4">');
        html.push('<div class="display-1 fw-bold text-' + overallColor + '">' + grade.overall_score + '</div>');
        html.push('<div class="text-muted">Overall Score</div>');
        html.push('</div>');

        // Section Scores
        if (grade.sections) {
            html.push('<div class="row g-3 mb-4">');
            var sectionNames = { formatting: 'Formatting', content: 'Content', relevance: 'Relevance', impact: 'Impact' };
            for (var key in grade.sections) {
                var section = grade.sections[key];
                var sectionColor = getScoreColor(section.score, 10);
                html.push('<div class="col-md-6">');
                html.push('<div class="card h-100">');
                html.push('<div class="card-body">');
                html.push('<div class="d-flex justify-content-between align-items-center mb-2">');
                html.push('<h6 class="mb-0">' + (sectionNames[key] || key) + '</h6>');
                html.push('<span class="badge bg-' + sectionColor + '">' + section.score + '/10</span>');
                html.push('</div>');
                html.push('<p class="text-muted small mb-0">' + escapeHtml(section.feedback || '') + '</p>');
                html.push('</div>');
                html.push('</div>');
                html.push('</div>');
            }
            html.push('</div>');
        }

        // Strengths
        if (grade.strengths && grade.strengths.length) {
            html.push('<div class="mb-4">');
            html.push('<h6 class="text-success"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="me-1" viewBox="0 0 16 16"><path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/></svg> Strengths</h6>');
            html.push('<ul class="mb-0">');
            grade.strengths.forEach(function(s) {
                html.push('<li>' + escapeHtml(s) + '</li>');
            });
            html.push('</ul>');
            html.push('</div>');
        }

        // Improvements
        if (grade.improvements && grade.improvements.length) {
            html.push('<div class="mb-4">');
            html.push('<h6 class="text-warning"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="me-1" viewBox="0 0 16 16"><path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/></svg> Areas for Improvement</h6>');
            html.push('<ul class="mb-0">');
            grade.improvements.forEach(function(s) {
                html.push('<li>' + escapeHtml(s) + '</li>');
            });
            html.push('</ul>');
            html.push('</div>');
        }

        // Summary
        if (grade.summary) {
            html.push('<div class="alert alert-light mb-0">');
            html.push('<h6 class="alert-heading">Summary</h6>');
            html.push('<p class="mb-0">' + escapeHtml(grade.summary) + '</p>');
            html.push('</div>');
        }

        container.innerHTML = html.join('');
    }
})();
</script>
