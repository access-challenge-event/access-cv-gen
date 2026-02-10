<!-- Status Section -->
 <section class="py-5 bg-light">
    <div class="container">
        <h2 class="mb-4 text-center">Staff Dashboard</h2>
        <p class="mb-4 text-center">Welcome back, <?= htmlspecialchars($user['username'] ?? 'User') ?></p>
    </div>
</section>

<!-- Messages -->
<section class="py-3">
    <div class="container">
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
    </div>
</section>

<!-- Add Job Section -->
<section class="py-4">
    <div class="container">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Add New Job Listing</h5>
                <button class="btn btn-sm btn-outline-primary d-flex align-items-center justify-content-center" type="button" data-bs-toggle="collapse" data-bs-target="#addJobForm" id="addJobToggle" style="width: 32px; height: 32px; padding: 0;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="toggle-icon" viewBox="0 0 16 16" style="transition: transform 0.2s ease;">
                        <path fill-rule="evenodd" d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2"/>
                    </svg>
                </button>
            </div>
            <div class="collapse" id="addJobForm">
                <div class="card-body">
                    <form method="POST" action="/staff/dashboard">
                        <input type="hidden" name="action" value="add_job">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="title" class="form-label">Job Title</label>
                                <input type="text" class="form-control" id="title" name="title" placeholder="e.g., Software Engineer" required>
                            </div>
                            <div class="col-md-6">
                                <label for="company" class="form-label">Company</label>
                                <input type="text" class="form-control" id="company" name="company" value="<?= htmlspecialchars($user['company'] ?? '') ?>" placeholder="e.g., Northbridge Labs" required>
                            </div>
                            <div class="col-md-4">
                                <label for="location" class="form-label">Location</label>
                                <input type="text" class="form-control" id="location" name="location" placeholder="e.g., London (Hybrid)" required>
                            </div>
                            <div class="col-md-4">
                                <label for="employment_type" class="form-label">Employment Type</label>
                                <select class="form-select" id="employment_type" name="employment_type" required>
                                    <option value="Full-time">Full-time</option>
                                    <option value="Part-time">Part-time</option>
                                    <option value="Contract">Contract</option>
                                    <option value="Internship">Internship</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="level" class="form-label">Level</label>
                                <select class="form-select" id="level" name="level" required>
                                    <option value="Entry-level">Entry-level</option>
                                    <option value="Junior">Junior</option>
                                    <option value="Mid-level">Mid-level</option>
                                    <option value="Senior">Senior</option>
                                    <option value="Lead">Lead</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control" id="description" name="description" rows="2" placeholder="Brief job description..." required></textarea>
                            </div>
                            <div class="col-md-6">
                                <label for="responsibilities" class="form-label">Responsibilities</label>
                                <textarea class="form-control" id="responsibilities" name="responsibilities" rows="3" placeholder="Key responsibilities..." required></textarea>
                            </div>
                            <div class="col-md-6">
                                <label for="requirements" class="form-label">Requirements</label>
                                <textarea class="form-control" id="requirements" name="requirements" rows="3" placeholder="Required skills and experience..." required></textarea>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Min Salary (Optional)</label>
                                <div class="input-group">
                                    <span class="input-group-text">£</span>
                                    <input type="number" class="form-control" name="salary_min" min="0" step="1000" placeholder="e.g., 30000">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Max Salary (Optional)</label>
                                <div class="input-group">
                                    <span class="input-group-text">£</span>
                                    <input type="number" class="form-control" name="salary_max" min="0" step="1000" placeholder="e.g., 40000">
                                </div>
                            </div>
                            <div class="col-md-4 d-flex align-items-end">
                                <button type="submit" class="btn btn-success">Add Job Listing</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- My Jobs Section -->
<?php if (!empty($user['company'])): ?>
<section class="py-4">
    <div class="container">
        <h2 class="mb-4 text-center">My Jobs &mdash; <?= htmlspecialchars($user['company']) ?> (<?= count($myJobs) ?>)</h2>

        <?php if (empty($myJobs)): ?>
            <div class="card">
                <div class="card-body text-center py-4">
                    <h6 class="text-muted">No jobs for <?= htmlspecialchars($user['company']) ?> yet</h6>
                    <p class="text-muted small">Add a job listing with your company name to see it here.</p>
                </div>
            </div>
        <?php else: ?>
            <div class="row g-4">
                <?php foreach ($myJobs as $job): ?>
                    <div class="col-md-6">
                        <div class="card h-100 border-primary">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h5 class="card-title mb-1"><?= htmlspecialchars($job['title']) ?></h5>
                                        <p class="text-muted mb-2"><?= htmlspecialchars($job['company']) ?> &middot; <?= htmlspecialchars($job['location']) ?></p>
                                    </div>
                                    <div class="d-flex gap-1">
                                        <span class="badge bg-primary"><?= htmlspecialchars($job['employment_type']) ?></span>
                                        <span class="badge bg-secondary"><?= htmlspecialchars($job['level']) ?></span>
                                    </div>
                                </div>
                                <p class="card-text small"><?= htmlspecialchars($job['description']) ?></p>
                                <?php if (!empty($job['salary_range'])): ?>
                                    <p class="mb-1"><strong>Salary:</strong> <?= htmlspecialchars($job['salary_range']) ?></p>
                                <?php endif; ?>
                                <small class="text-muted">Posted: <?= date('M j, Y', strtotime($job['posted_date'])) ?></small>
                            </div>
                            <div class="card-footer bg-transparent d-flex justify-content-end gap-2">
                                <button type="button" class="btn btn-sm btn-outline-primary"
                                        onclick='showEditModal(<?= json_encode($job, JSON_HEX_APOS | JSON_HEX_QUOT) ?>)'>
                                    Edit
                                </button>
                                <button type="button" class="btn btn-sm btn-outline-danger"
                                        onclick="showDeleteModal('<?= $job['job_id'] ?>', '<?= htmlspecialchars($job['title']) ?>')">
                                    Delete
                                </button>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>
<?php endif; ?>

<!-- All Jobs Section -->
<section class="py-4">
    <div class="container">
        <h2 class="mb-4 text-center">All Other Jobs (<?= count($allJobs) ?>)</h2>

        <?php if (empty($allJobs)): ?>
            <div class="card">
                <div class="card-body text-center py-5">
                    <h5 class="text-muted">No other job listings</h5>
                </div>
            </div>
        <?php else: ?>
            <div class="row g-4">
                <?php foreach ($allJobs as $job): ?>
                    <div class="col-md-6">
                        <div class="card h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h5 class="card-title mb-1"><?= htmlspecialchars($job['title']) ?></h5>
                                        <p class="text-muted mb-2"><?= htmlspecialchars($job['company']) ?> &middot; <?= htmlspecialchars($job['location']) ?></p>
                                    </div>
                                    <div class="d-flex gap-1">
                                        <span class="badge bg-primary"><?= htmlspecialchars($job['employment_type']) ?></span>
                                        <span class="badge bg-secondary"><?= htmlspecialchars($job['level']) ?></span>
                                    </div>
                                </div>
                                <p class="card-text small"><?= htmlspecialchars($job['description']) ?></p>
                                <?php if (!empty($job['salary_range'])): ?>
                                    <p class="mb-1"><strong>Salary:</strong> <?= htmlspecialchars($job['salary_range']) ?></p>
                                <?php endif; ?>
                                <small class="text-muted">Posted: <?= date('M j, Y', strtotime($job['posted_date'])) ?></small>
                            </div>
                            <div class="card-footer bg-transparent d-flex justify-content-end gap-2">
                                <button type="button" class="btn btn-sm btn-outline-primary"
                                        onclick='showEditModal(<?= json_encode($job, JSON_HEX_APOS | JSON_HEX_QUOT) ?>)'>
                                    Edit
                                </button>
                                <button type="button" class="btn btn-sm btn-outline-danger"
                                        onclick="showDeleteModal('<?= $job['job_id'] ?>', '<?= htmlspecialchars($job['title']) ?>')">
                                    Delete
                                </button>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>

<!-- Delete Job Modal -->
<div class="modal fade" id="deleteJobModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Delete Job</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete <strong id="deleteJobName"></strong>?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form method="POST" action="/staff/dashboard" class="d-inline">
                    <input type="hidden" name="action" value="delete_job">
                    <input type="hidden" name="job_id" id="deleteJobId">
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit Job Modal -->
<div class="modal fade" id="editJobModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Job Listing</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="/staff/dashboard">
                <input type="hidden" name="action" value="edit_job">
                <input type="hidden" name="job_id" id="editJobId">
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Job Title</label>
                            <input type="text" class="form-control" name="title" id="editTitle" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Company</label>
                            <input type="text" class="form-control" name="company" id="editCompany" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Location</label>
                            <input type="text" class="form-control" name="location" id="editLocation" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Employment Type</label>
                            <select class="form-select" name="employment_type" id="editEmploymentType" required>
                                <option value="Full-time">Full-time</option>
                                <option value="Part-time">Part-time</option>
                                <option value="Contract">Contract</option>
                                <option value="Internship">Internship</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Level</label>
                            <select class="form-select" name="level" id="editLevel" required>
                                <option value="Entry-level">Entry-level</option>
                                <option value="Junior">Junior</option>
                                <option value="Mid-level">Mid-level</option>
                                <option value="Senior">Senior</option>
                                <option value="Lead">Lead</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Description</label>
                            <textarea class="form-control" name="description" id="editDescription" rows="2" required></textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Responsibilities</label>
                            <textarea class="form-control" name="responsibilities" id="editResponsibilities" rows="3" required></textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Requirements</label>
                            <textarea class="form-control" name="requirements" id="editRequirements" rows="3" required></textarea>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Min Salary (Optional)</label>
                            <div class="input-group">
                                <span class="input-group-text">£</span>
                                <input type="number" class="form-control" name="salary_min" id="editSalaryMin" min="0" step="1000">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Max Salary (Optional)</label>
                            <div class="input-group">
                                <span class="input-group-text">£</span>
                                <input type="number" class="form-control" name="salary_max" id="editSalaryMax" min="0" step="1000">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function showDeleteModal(jobId, jobName) {
    document.getElementById('deleteJobId').value = jobId;
    document.getElementById('deleteJobName').textContent = jobName;
    new bootstrap.Modal(document.getElementById('deleteJobModal')).show();
}

function showEditModal(job) {
    document.getElementById('editJobId').value = job.job_id;
    document.getElementById('editTitle').value = job.title;
    document.getElementById('editCompany').value = job.company;
    document.getElementById('editLocation').value = job.location;
    document.getElementById('editEmploymentType').value = job.employment_type;
    document.getElementById('editLevel').value = job.level;
    document.getElementById('editDescription').value = job.description;
    document.getElementById('editResponsibilities').value = job.responsibilities;
    document.getElementById('editRequirements').value = job.requirements;
    // Parse salary_range like "£30,000 - £40,000" into min/max numbers
    var salaryMin = '', salaryMax = '';
    if (job.salary_range) {
        var parts = job.salary_range.split('-').map(function(s) {
            return s.replace(/[^0-9]/g, '');
        });
        salaryMin = parts[0] || '';
        salaryMax = parts[1] || '';
    }
    document.getElementById('editSalaryMin').value = salaryMin;
    document.getElementById('editSalaryMax').value = salaryMax;
    new bootstrap.Modal(document.getElementById('editJobModal')).show();
}

var icon = document.querySelector('#addJobToggle .toggle-icon');
document.getElementById('addJobForm').addEventListener('show.bs.collapse', function() {
    icon.style.transform = 'rotate(45deg)';
});
document.getElementById('addJobForm').addEventListener('hide.bs.collapse', function() {
    icon.style.transform = 'rotate(0deg)';
});
</script>