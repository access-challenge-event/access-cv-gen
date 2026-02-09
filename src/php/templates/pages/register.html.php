<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card shadow-sm border-0">
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        <h2 class="card-title mb-2">Create an Account</h2>
                        <p class="text-muted mb-0">Sign up to start building your CV.</p>
                    </div>

                    <?php if (isset($error) && $error): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <?php echo htmlspecialchars($error); ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <form method="POST" action="register" class="row g-3">
                        <div class="col-12">
                            <label for="reg-email" class="form-label">Email</label>
                            <input type="email" id="reg-email" name="register[email]" class="form-control" placeholder="you@example.com" required />
                        </div>

                        <div class="col-12">
                            <label for="reg-username" class="form-label">Username</label>
                            <input type="text" id="reg-username" name="register[username]" class="form-control" placeholder="yourname" required />
                        </div>
                        
                        <div class="col-12">
                            <label for="reg-password" class="form-label">Password</label>
                            <input type="password" id="reg-password" name="register[password]" class="form-control" placeholder="••••••••" required />
                        </div>
                        
                        <div class="col-12">
                            <button type="submit" id="submit" name="submit" class="btn btn-primary w-100">Register</button>
                        </div>
                    </form>

                    <p class="text-center text-muted mt-4 mb-0">
                        Already have an account? <a href="/auth/login">Sign in</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
