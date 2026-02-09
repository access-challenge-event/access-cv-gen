<!-- My CVs Page -->
<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-10 mx-auto">
                <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
                    <div>
                        <h1 class="mb-1">My CVs</h1>
                        <p class="text-muted mb-0">View and manage your generated CVs.</p>
                    </div>
                    <a href="<?php echo get_page_url('create'); ?>" class="btn btn-primary">Create New CV</a>
                </div>

                <?php if (!empty($error)): ?>
                    <div class="alert alert-warning" role="alert">
                        <?php echo htmlspecialchars($error); ?>
                    </div>
                <?php elseif (empty($cvs)): ?>
                    <div class="card">
                        <div class="card-body text-center py-5">
                            <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="currentColor" class="text-muted mb-3" viewBox="0 0 16 16">
                                <path d="M14 4.5V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h5.5L14 4.5zM10 4a1 1 0 0 1-1-1V1.5L14 6h-3a1 1 0 0 1-1-1z"/>
                            </svg>
                            <h5 class="mb-2">No CVs yet</h5>
                            <p class="text-muted mb-4">You haven't generated any CVs yet. Create your first one now!</p>
                            <a href="<?php echo get_page_url('create'); ?>" class="btn btn-primary">Create Your First CV</a>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="row g-4">
                        <?php foreach ($cvs as $cv): ?>
                            <?php
                                $score = $cv['score'] ?? null;
                                $scoreClass = 'secondary';
                                if ($score !== null) {
                                    if ($score >= 70) $scoreClass = 'success';
                                    elseif ($score >= 50) $scoreClass = 'warning';
                                    else $scoreClass = 'danger';
                                }
                                $dateCreated = date('M j, Y', strtotime($cv['date_created']));
                                $timeAgo = date('g:i A', strtotime($cv['date_created']));
                            ?>
                            <div class="col-md-6 col-lg-4">
                                <div class="card h-100 shadow-sm">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-start mb-3">
                                            <div>
                                                <?php if ($score !== null): ?>
                                                    <span class="badge bg-<?php echo $scoreClass; ?> fs-5"><?php echo $score; ?></span>
                                                    <small class="text-muted d-block mt-1">Score</small>
                                                <?php else: ?>
                                                    <span class="badge bg-secondary">--</span>
                                                    <small class="text-muted d-block mt-1">Not graded</small>
                                                <?php endif; ?>
                                            </div>
                                            <div class="text-end">
                                                <small class="text-muted"><?php echo $dateCreated; ?></small>
                                                <small class="text-muted d-block"><?php echo $timeAgo; ?></small>
                                            </div>
                                        </div>

                                        <?php if (!empty($cv['job_target'])): ?>
                                            <h6 class="card-title mb-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="me-1" viewBox="0 0 16 16">
                                                    <path d="M6.5 1A1.5 1.5 0 0 0 5 2.5V3H1.5A1.5 1.5 0 0 0 0 4.5v8A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-8A1.5 1.5 0 0 0 14.5 3H11v-.5A1.5 1.5 0 0 0 9.5 1h-3zm0 1h3a.5.5 0 0 1 .5.5V3H6v-.5a.5.5 0 0 1 .5-.5z"/>
                                                </svg>
                                                <?php echo htmlspecialchars($cv['job_target']); ?>
                                            </h6>
                                        <?php else: ?>
                                            <h6 class="card-title text-muted mb-2">General CV</h6>
                                        <?php endif; ?>

                                        <p class="card-text text-muted small mb-0">
                                            CV #<?php echo $cv['cv_id']; ?>
                                        </p>
                                    </div>
                                    <div class="card-footer bg-transparent border-top-0">
                                        <a href="/app/viewCv?id=<?php echo $cv['cv_id']; ?>" class="btn btn-outline-primary btn-sm w-100">
                                            View CV
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <!-- Summary Stats -->
                    <?php
                        $totalCvs = count($cvs);
                        $gradedCvs = array_filter($cvs, fn($c) => $c['score'] !== null);
                        $avgScore = count($gradedCvs) > 0
                            ? round(array_sum(array_column($gradedCvs, 'score')) / count($gradedCvs))
                            : null;
                        $bestScore = count($gradedCvs) > 0
                            ? max(array_column($gradedCvs, 'score'))
                            : null;
                    ?>
                    <div class="row g-3 mt-4">
                        <div class="col-md-4">
                            <div class="card bg-light">
                                <div class="card-body text-center">
                                    <div class="h3 mb-0"><?php echo $totalCvs; ?></div>
                                    <small class="text-muted">Total CVs</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-light">
                                <div class="card-body text-center">
                                    <div class="h3 mb-0"><?php echo $avgScore ?? '--'; ?></div>
                                    <small class="text-muted">Average Score</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-light">
                                <div class="card-body text-center">
                                    <div class="h3 mb-0 text-success"><?php echo $bestScore ?? '--'; ?></div>
                                    <small class="text-muted">Best Score</small>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
