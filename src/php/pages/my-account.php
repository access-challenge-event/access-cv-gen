<!-- My Account Page -->
<section class="py-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-4">
                <div class="card h-100">
                    <div class="card-body text-center">
                        <div class="display-4 mb-3">👤</div>
                        <h1 class="h3 mb-2">My Account</h1>
                        <p class="text-muted mb-4">Manage your profile and application details.</p>
                        <a href="<?php echo get_page_url('upload-cv'); ?>" class="btn btn-primary w-100">Upload CV</a>
                    </div>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="card mb-4">
                    <div class="card-body">
                        <h2 class="h5 mb-3">Profile Details</h2>
                        <form>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="accountFullName" class="form-label">Full Name</label>
                                    <input type="text" class="form-control" id="accountFullName" placeholder="Alex Morgan" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="accountEmail" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="accountEmail" placeholder="alex@example.com" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="accountPhone" class="form-label">Phone</label>
                                    <input type="tel" class="form-control" id="accountPhone" placeholder="+1 (555) 123-4567">
                                </div>
                                <div class="col-md-6">
                                    <label for="accountLocation" class="form-label">Current Location</label>
                                    <input type="text" class="form-control" id="accountLocation" placeholder="City, State">
                                </div>
                                <div class="col-12">
                                    <label for="accountSummary" class="form-label">Short Summary</label>
                                    <textarea class="form-control" id="accountSummary" rows="3" placeholder="Highlight your strengths and goals."></textarea>
                                </div>
                            </div>

                            <div class="d-flex gap-2 mt-4">
                                <button type="submit" class="btn btn-primary">Save Changes</button>
                                <a href="<?php echo get_page_url('my-cvs'); ?>" class="btn btn-outline-secondary">View My CVs</a>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <h2 class="h5 mb-3">Application Preferences</h2>
                        <form>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="preferredRole" class="form-label">Preferred Role</label>
                                    <input type="text" class="form-control" id="preferredRole" placeholder="Junior Developer">
                                </div>
                                <div class="col-md-6">
                                    <label for="preferredWork" class="form-label">Work Style</label>
                                    <select class="form-select" id="preferredWork">
                                        <option value="">Select</option>
                                        <option>On-site</option>
                                        <option>Hybrid</option>
                                        <option>Remote</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="availability" class="form-label">Availability</label>
                                    <select class="form-select" id="availability">
                                        <option value="">Select</option>
                                        <option>Immediate</option>
                                        <option>2 weeks</option>
                                        <option>1 month</option>
                                        <option>More than 1 month</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="salaryRange" class="form-label">Salary Expectation</label>
                                    <input type="text" class="form-control" id="salaryRange" placeholder="$40k - $55k">
                                </div>
                            </div>

                            <button type="submit" class="btn btn-outline-primary mt-4">Save Preferences</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
