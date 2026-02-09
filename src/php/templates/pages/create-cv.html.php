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

                            <button type="submit" class="btn btn-primary">Create CV</button>
                            <a href="<?php echo get_page_url('home'); ?>" class="btn btn-secondary">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
