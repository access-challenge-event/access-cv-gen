<!-- Status Section -->
<section class="py-5 bg-light">
    <div class="container">
        <h2 class="mb-4 text-center">System Status</h2>

        <!-- Core Services -->
        <h5 class="mb-3">Core Services</h5>
        <div class="row g-3 mb-4">
            <!-- PHP Status -->
            <div class="col-md-4">
                <div class="card h-100">
                    <div class="card-body text-center">
                        <h5 class="card-title">🐘 PHP Server</h5>
                        <p class="badge bg-success fs-6">Running</p>
                        <p class="text-muted small mt-2">PHP <?php echo htmlspecialchars($phpVersion); ?></p>
                        <p class="text-muted small"><?php echo htmlspecialchars($serverSoftware); ?></p>
                    </div>
                </div>
            </div>

            <!-- Database Status -->
            <div class="col-md-4">
                <div class="card h-100">
                    <div class="card-body text-center">
                        <h5 class="card-title">🗄️ Database</h5>
                        <p class="badge <?php echo $dbConnected ? 'bg-success' : 'bg-danger'; ?> fs-6">
                            <?php echo $dbConnected ? '✓ Connected' : '✗ Disconnected'; ?>
                        </p>
                        <p class="text-muted small mt-2">MySQL <?php echo $dbConnected && $dbVersion ? htmlspecialchars($dbVersion) : ''; ?></p>
                    </div>
                </div>
            </div>

            <!-- Memory -->
            <div class="col-md-4">
                <div class="card h-100">
                    <div class="card-body text-center">
                        <h5 class="card-title">💾 Memory</h5>
                        <p class="badge bg-info fs-6"><?php echo $memoryUsage; ?> MB</p>
                        <p class="text-muted small mt-2">Current PHP memory usage</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- API Keys -->
        <h5 class="mb-3">API Integrations</h5>
        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <div class="card h-100">
                    <div class="card-body text-center">
                        <h5 class="card-title">🤖 DeepSeek</h5>
                        <p class="badge <?php echo $deepseekKey ? 'bg-success' : 'bg-danger'; ?> fs-6">
                            <?php echo $deepseekKey ? '✓ Configured' : '✗ Not Set'; ?>
                        </p>
                        <p class="text-muted small mt-2">CV generation AI</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100">
                    <div class="card-body text-center">
                        <h5 class="card-title">✨ Gemini</h5>
                        <p class="badge <?php echo $geminiKey ? 'bg-success' : 'bg-warning'; ?> fs-6">
                            <?php echo $geminiKey ? '✓ Configured' : '⏳ Not Set'; ?>
                        </p>
                        <p class="text-muted small mt-2">CV grading AI</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100">
                    <div class="card-body text-center">
                        <h5 class="card-title">🔑 Google OAuth</h5>
                        <p class="badge <?php echo $googleClientId ? 'bg-success' : 'bg-danger'; ?> fs-6">
                            <?php echo $googleClientId ? '✓ Configured' : '✗ Not Set'; ?>
                        </p>
                        <p class="text-muted small mt-2">Login authentication</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- App Stats -->
        <h5 class="mb-3">Application Stats</h5>
        <div class="row g-3">
            <div class="col-md-4">
                <div class="card h-100">
                    <div class="card-body text-center">
                        <h5 class="card-title">👥 Users</h5>
                        <p class="h3 mb-0"><?php echo $totalUsers; ?></p>
                        <p class="text-muted small mt-2">Registered users</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100">
                    <div class="card-body text-center">
                        <h5 class="card-title">📄 CVs</h5>
                        <p class="h3 mb-0"><?php echo $totalCvs; ?></p>
                        <p class="text-muted small mt-2">Generated CVs</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100">
                    <div class="card-body text-center">
                        <h5 class="card-title">💼 Jobs</h5>
                        <p class="h3 mb-0"><?php echo $totalJobs; ?></p>
                        <p class="text-muted small mt-2">Active job listings</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>