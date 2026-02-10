<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="display-4 fw-bold mb-3">Create Your Professional CV</h1>
                <p class="lead mb-4">
                    Generate beautiful, AI-enhanced CVs with the power of Gemini. 
                    Highlight your skills, experience, and education effortlessly.
                </p>
                <?php if (is_logged_in()): ?>
                    <a href="<?php echo get_page_url('create'); ?>" class="btn btn-light btn-lg">
                        Get Started →
                    </a>
                <?php else: ?>
                    <a href="/auth/login" class="btn btn-light btn-lg">
                        Sign In to Get Started →
                    </a>
                <?php endif; ?>
            </div>
            <div class="col-md-4 text-center">
                <div class="display-1">📋</div>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="py-5">
    <div class="container">
        <h2 class="mb-5 text-center">Features</h2>
        <div class="row g-4">
            <div class="col-md-6">
                <div class="d-flex gap-3">
                    <div class="fs-3">✨</div>
                    <div>
                        <h5>AI-Powered Generation</h5>
                        <p class="text-muted">Leverage Gemini API to create compelling CV content tailored to your profile.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="d-flex gap-3">
                    <div class="fs-3">📱</div>
                    <div>
                        <h5>Responsive Design</h5>
                        <p class="text-muted">Beautiful, responsive layouts that look great on any device or screen size.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="d-flex gap-3">
                    <div class="fs-3">💾</div>
                    <div>
                        <h5>Data Persistence</h5>
                        <p class="text-muted">All your CVs are safely stored in our secure MySQL database.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="d-flex gap-3">
                    <div class="fs-3">🚀</div>
                    <div>
                        <h5>Quick & Easy</h5>
                        <p class="text-muted">Create professional CVs in minutes with our intuitive interface.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>