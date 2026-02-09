<!-- Upload CV Page -->
<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <h1 class="mb-3">Upload Your CV</h1>
                <p class="text-muted mb-4">Add your CV and answer a few quick questions to speed up applications.</p>

                <div class="card">
                    <div class="card-body">
                        <form enctype="multipart/form-data">
                            <div class="mb-4">
                                <label for="cvFile" class="form-label">CV File</label>
                                <input type="file" class="form-control" id="cvFile" accept=".pdf,.doc,.docx" required>
                                <div class="form-text">Accepted formats: PDF, DOC, DOCX. Max 10MB.</div>
                            </div>

                            <h2 class="h5 mb-3">Application Questions</h2>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="roughLocation" class="form-label">Rough Location</label>
                                    <input type="text" class="form-control" id="roughLocation" placeholder="City, State">
                                </div>
                                <div class="col-md-6">
                                    <label for="educationLevel" class="form-label">Highest Education</label>
                                    <select class="form-select" id="educationLevel">
                                        <option value="">Select</option>
                                        <option>High School</option>
                                        <option>Associate Degree</option>
                                        <option>Bachelor Degree</option>
                                        <option>Master Degree</option>
                                        <option>Doctorate</option>
                                        <option>Other</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="fieldOfStudy" class="form-label">Field of Study</label>
                                    <input type="text" class="form-control" id="fieldOfStudy" placeholder="Computer Science">
                                </div>
                                <div class="col-md-6">
                                    <label for="gradYear" class="form-label">Graduation Year</label>
                                    <input type="number" class="form-control" id="gradYear" min="1960" max="2035" placeholder="2025">
                                </div>
                                <div class="col-md-6">
                                    <label for="workAuthorization" class="form-label">Work Authorization</label>
                                    <select class="form-select" id="workAuthorization">
                                        <option value="">Select</option>
                                        <option>Citizen or permanent resident</option>
                                        <option>Student or temporary visa</option>
                                        <option>Requires sponsorship</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="preferredLocation" class="form-label">Preferred Work Location</label>
                                    <input type="text" class="form-control" id="preferredLocation" placeholder="Remote or specific city">
                                </div>
                                <div class="col-md-6">
                                    <label for="availabilityDate" class="form-label">Availability Date</label>
                                    <input type="date" class="form-control" id="availabilityDate">
                                </div>
                                <div class="col-md-6">
                                    <label for="contactPermission" class="form-label">Can we contact you?</label>
                                    <select class="form-select" id="contactPermission">
                                        <option value="">Select</option>
                                        <option>Yes, by email</option>
                                        <option>Yes, by phone</option>
                                        <option>Yes, either</option>
                                        <option>No</option>
                                    </select>
                                </div>
                                <div class="col-12">
                                    <label for="additionalNotes" class="form-label">Additional Notes</label>
                                    <textarea class="form-control" id="additionalNotes" rows="3" placeholder="Anything else we should know?"></textarea>
                                </div>
                            </div>

                            <div class="d-flex gap-2 mt-4">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <a href="<?php echo get_page_url('my-account'); ?>" class="btn btn-outline-secondary">Back to My Account</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
