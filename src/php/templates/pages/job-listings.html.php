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
                            <th scope="col">Actions</th>
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
                                <td>
                                    <button
                                        type="button"
                                        class="btn btn-sm btn-outline-secondary generate-interview-qs"
                                        data-role="<?php echo htmlspecialchars($job['title'] . ' at ' . $job['company']); ?>"
                                    >
                                        Interview Questions
                                    </button>
                                </td>
                            </tr>
                            <tr class="table-light">
                                <td colspan="8">
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

<!-- Interview Questions Modal -->
<div class="modal fade" id="interviewQsModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <h5 class="modal-title mb-1">Interview Questions</h5>
                    <small id="interview-qs-role" class="text-muted"></small>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="interview-qs-loading" class="text-center py-4">
                    <div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div>
                    <p class="mt-2 text-muted mb-0">Generating interview questions...</p>
                </div>
                <div id="interview-qs-content" style="display:none;"></div>
                <div id="interview-qs-error" class="alert alert-danger" style="display:none;"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
(function () {
    function showModal() {
        var modalEl = document.getElementById('interviewQsModal');
        return new bootstrap.Modal(modalEl);
    }

    function escapeHtml(text) {
        var div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    function renderQuestions(container, questions) {
        var html = ['<div class="accordion" id="interviewQsAccordion">'];
        questions.forEach(function (q, index) {
            var num = q.question_number || (index + 1);
            var collapseId = 'collapse-q-' + num;
            var headingId = 'heading-q-' + num;
            var expanded = index === 0 ? 'true' : 'false';
            var showClass = index === 0 ? 'show' : '';
            var collapsedClass = index === 0 ? '' : 'collapsed';

            html.push('<div class="accordion-item">');
            html.push('<h2 class="accordion-header" id="' + headingId + '">');
            html.push('<button class="accordion-button ' + collapsedClass + '" type="button" data-bs-toggle="collapse" data-bs-target="#' + collapseId + '" aria-expanded="' + expanded + '" aria-controls="' + collapseId + '">');
            html.push('<span class="badge bg-primary me-2">' + num + '</span>');
            html.push(escapeHtml(q.question || ''));
            html.push('</button>');
            html.push('</h2>');
            html.push('<div id="' + collapseId + '" class="accordion-collapse collapse ' + showClass + '" aria-labelledby="' + headingId + '" data-bs-parent="#interviewQsAccordion">');
            html.push('<div class="accordion-body">');
            html.push('<p class="mb-2"><strong>Example Answer:</strong></p>');
            html.push('<p class="text-muted mb-0">' + escapeHtml(q.answer || '') + '</p>');
            html.push('</div>');
            html.push('</div>');
            html.push('</div>');
        });
        html.push('</div>');
        container.innerHTML = html.join('');
    }

    document.addEventListener('click', function (ev) {
        var btn = ev.target.closest('.generate-interview-qs');
        if (!btn) return;
        var role = btn.getAttribute('data-role') || '';

        var modal = showModal();
        var loading = document.getElementById('interview-qs-loading');
        var content = document.getElementById('interview-qs-content');
        var errorEl = document.getElementById('interview-qs-error');
        var roleEl = document.getElementById('interview-qs-role');

        loading.style.display = '';
        content.style.display = 'none';
        errorEl.style.display = 'none';
        content.innerHTML = '';
        roleEl.textContent = role;

        modal.show();

        btn.disabled = true;

        fetch('/api/router.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ action: 'generate_interview_questions', data: { role: role } })
        }).then(function (res) {
            return res.json();
        }).then(function (json) {
            btn.disabled = false;
            loading.style.display = 'none';
            if (json && json.success && json.result && json.result.questions) {
                var qs = json.result.questions;
                content.style.display = '';
                renderQuestions(content, qs);
            } else if (json && json.error) {
                errorEl.style.display = '';
                errorEl.textContent = json.error + (json.detail ? (': ' + json.detail) : '');
            } else {
                errorEl.style.display = '';
                errorEl.textContent = 'Unexpected response from server.';
            }
        }).catch(function (err) {
            btn.disabled = false;
            loading.style.display = 'none';
            errorEl.style.display = '';
            errorEl.textContent = 'Network or server error.';
            console.error(err);
        });
    });
})();
</script>
