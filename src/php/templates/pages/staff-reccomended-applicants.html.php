<style>
.cv-preview {
    max-height: 220px;
    overflow: hidden;
    position: relative;
}
.cv-preview::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    height: 60px;
    background: linear-gradient(transparent, white);
}
.cv-preview h2 {
    font-size: 1.1rem;
    margin-bottom: 0.25rem;
}
.cv-preview h3 {
    font-size: 1rem;
    margin-top: 0.75rem;
}
.cv-preview ul {
    padding-left: 1rem;
}
</style>

<section class="py-5 bg-light">
    <div class="container">
        <h2 class="mb-1 text-center">Recommended Applicants</h2>
        <p class="mb-0 text-center text-muted">
            Welcome back, <?= htmlspecialchars($user['username'] ?? 'User') ?>
            — showing CVs submitted for <strong><?= htmlspecialchars($user['company'] ?? 'your company') ?></strong> jobs.
        </p>
    </div>
</section>

<section class="py-5">
    <div class="container">

        <?php if (empty($applicants)): ?>
            <!-- Empty State -->
            <div class="text-center py-5">
                <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="currentColor" class="text-muted mb-3" viewBox="0 0 16 16">
                    <path d="M15 14s1 0 1-1-1-4-5-4-5 3-5 4 1 1 1 1h8Zm-7.978-1A.261.261 0 0 1 7 12.996c.001-.264.167-1.03.76-1.72C8.312 10.629 9.282 10 11 10c1.717 0 2.687.63 3.24 1.276.593.69.758 1.457.76 1.72l-.008.002a.274.274 0 0 1-.014.002H7.022ZM11 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4Zm3-2a3 3 0 1 1-6 0 3 3 0 0 1 6 0ZM6.936 9.28a5.88 5.88 0 0 0-1.23-.247A7.35 7.35 0 0 0 5 9c-4 0-5 3-5 4 0 .667.333 1 1 1h4.216A2.238 2.238 0 0 1 5 13c0-.26.164-1.03.76-1.724.545-.636 1.492-1.256 3.176-1.496ZM1 5.5a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0ZM4.5 4a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5Z"/>
                </svg>
                <h4 class="text-muted">No Applicants Yet</h4>
                <p class="text-muted mb-4">
                    <?php if (empty($companyJobs)): ?>
                        Your company doesn't have any job listings yet. Add some jobs from the
                        <a href="<?= get_page_url('dashboard') ?>">Dashboard</a> to start receiving applicants.
                    <?php else: ?>
                        No CVs have been submitted targeting your company's jobs yet. Applicants will appear here once they generate CVs for your listings.
                    <?php endif; ?>
                </p>
            </div>
        <?php else: ?>
            <!-- Summary -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="mb-0"><?= count($applicants) ?> Applicant<?= count($applicants) !== 1 ? 's' : '' ?> Found</h5>
                <span class="text-muted">Sorted by CV score (highest first)</span>
            </div>

            <div class="row g-4">
                <?php foreach ($applicants as $i => $applicant): ?>
                    <?php
                        $initials = '';
                        $nameParts = explode(' ', $applicant['name']);
                        foreach ($nameParts as $part) {
                            $initials .= strtoupper(mb_substr($part, 0, 1));
                        }
                        $initials = mb_substr($initials, 0, 2);

                        $score = $applicant['score'];
                        $scoreClass = 'secondary';
                        if ($score !== null) {
                            if ($score >= 70) $scoreClass = 'success';
                            elseif ($score >= 50) $scoreClass = 'warning';
                            else $scoreClass = 'danger';
                        }

                        $bgColors = ['primary', 'success', 'info', 'secondary', 'warning'];
                        $bgColor = $bgColors[$i % count($bgColors)];
                    ?>
                    <div class="col-lg-6 col-md-6">
                        <div class="card shadow-sm h-100">
                            <div class="card-body d-flex flex-column">

                                <!-- Header -->
                                <div class="d-flex align-items-center mb-3">
                                    <div class="rounded-circle bg-<?= $bgColor ?> text-white d-flex justify-content-center align-items-center me-3"
                                         style="width: 48px; height: 48px; font-size: 20px; flex-shrink: 0;">
                                        <?= htmlspecialchars($initials) ?>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h5 class="mb-0"><?= htmlspecialchars($applicant['name']) ?></h5>
                                        <small class="text-muted"><?= htmlspecialchars($applicant['email']) ?></small>
                                    </div>
                                    <?php if ($score !== null): ?>
                                        <span class="badge bg-<?= $scoreClass ?> fs-6 ms-2">
                                            <?= $score ?>/100
                                        </span>
                                    <?php endif; ?>
                                </div>

                                <!-- Target Job -->
                                <div class="mb-3">
                                    <span class="badge bg-primary bg-opacity-10 text-primary">
                                        Targeting: <?= htmlspecialchars($applicant['job_title']) ?>
                                    </span>
                                    <small class="text-muted ms-2">
                                        Submitted <?= date('M j, Y', strtotime($applicant['date_created'])) ?>
                                    </small>
                                </div>

                                <!-- CV Preview -->
                                <div class="cv-preview mb-3" style="font-size: 0.85rem;">
                                    <?= $applicant['cv_html'] ?>
                                </div>

                                <!-- Footer -->
                                <div class="mt-auto d-flex justify-content-between align-items-center pt-2 border-top">
                                    <div>
                                        <?php if ($score !== null): ?>
                                            <?php if ($score >= 70): ?>
                                                <span class="badge bg-success">Strong Match</span>
                                            <?php elseif ($score >= 50): ?>
                                                <span class="badge bg-warning text-dark">Moderate Match</span>
                                            <?php else: ?>
                                                <span class="badge bg-danger">Weak Match</span>
                                            <?php endif; ?>
                                        <?php else: ?>
                                            <span class="badge bg-secondary">Not Scored</span>
                                        <?php endif; ?>
                                    </div>
                                    <button type="button" class="btn btn-outline-primary btn-sm"
                                            onclick="showFullCv(<?= $applicant['cv_id'] ?>)">
                                        View Full CV
                                    </button>
                                </div>

                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

    </div>
</section>

<!-- Full CV Modal -->
<div class="modal fade" id="fullCvModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Full CV</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body bg-white p-4" id="fullCvContent">
                <div class="text-center py-4">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
var cvContents = <?= json_encode(
    array_map(function($a) {
        return ['id' => $a['cv_id'], 'html' => $a['cv_html'], 'name' => $a['name']];
    }, $applicants ?? [])
) ?>;

function showFullCv(cvId) {
    var modal = new bootstrap.Modal(document.getElementById('fullCvModal'));
    var container = document.getElementById('fullCvContent');
    var titleEl = document.querySelector('#fullCvModal .modal-title');

    var cv = cvContents.find(function(c) { return c.id == cvId; });
    if (cv) {
        titleEl.textContent = cv.name + "'s CV";
        container.innerHTML = cv.html;
    } else {
        titleEl.textContent = 'Full CV';
        container.innerHTML = '<p class="text-muted">CV content not available.</p>';
    }
    modal.show();
}
</script>
