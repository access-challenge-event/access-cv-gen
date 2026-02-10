<style>
.cv-preview {
    max-height: 220px;
    overflow: hidden;
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
        <h2 class="mb-4 text-center">Reccomended Applicants</h2>
        <p class="mb-4 text-center">Welcome back, <?= htmlspecialchars($user['username'] ?? 'User') ?></P>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <h2 class="mb-5 text-center">Reccomended Applicants</h2>
        <div class="row g-4">
            
        
        <div class="row g-4">

    <!-- ===== Software Engineer (UK) ===== -->
    <div class="col-lg-6 col-md-6">
        <div class="card shadow-sm h-100">
            <div class="card-body d-flex flex-column">

                <!-- Header -->
                <div class="d-flex align-items-center mb-3">
                    <div class="rounded-circle bg-primary text-white d-flex justify-content-center align-items-center me-3"
                         style="width: 48px; height: 48px; font-size: 20px;">
                        SE
                    </div>
                    <div>
                        <h5 class="mb-0">Software Engineer</h5>
                        <small class="text-muted">Match Score: 91%</small>
                    </div>
                </div>

                <!-- CV Preview -->
                <div class="cv-preview mb-3" style="font-size: 0.9rem; max-height: 240px; overflow: hidden;">

                    <h6 class="mb-1 fw-bold">James Walker</h6>
                    <p class="mb-2 text-muted">
                        james.walker@email.co.uk · +44 7700 900123 · London, UK
                    </p>

                    <h6 class="fw-bold">Professional Summary</h6>
                    <p>
                        Experienced Software Engineer with over 5 years’ experience developing and maintaining
                        scalable web applications. Strong background in PHP, JavaScript, and modern frameworks,
                        with a focus on clean architecture and performance.
                    </p>

                    <h6 class="fw-bold">Work Experience</h6>
                    <ul class="ps-3">
                        <li>
                            <strong>Senior Software Engineer</strong> – TechNova Ltd, London (Mar 2021 – Present)
                            <p class="mb-1">
                                Led backend development using Laravel, improved API response times by 35%,
                                and worked closely with product teams to deliver reliable SaaS platforms.
                            </p>
                        </li>
                        <li>
                            <strong>Software Engineer</strong> – CodeCraft Solutions, Manchester (Jun 2018 – Feb 2021)
                            <p class="mb-1">
                                Developed RESTful APIs, maintained legacy systems, and supported CI/CD pipelines.
                            </p>
                        </li>
                    </ul>

                    <h6 class="fw-bold">Education</h6>
                    <ul class="ps-3">
                        <li>BSc (Hons) Computer Science – University of Manchester (2018)</li>
                    </ul>

                    <h6 class="fw-bold">Skills</h6>
                    <ul class="ps-3 mb-0">
                        <li>PHP, Laravel, MySQL</li>
                        <li>JavaScript, React</li>
                        <li>Docker, Git, REST APIs</li>
                        <li>Agile / Scrum</li>
                    </ul>

                </div>

                <!-- Footer -->
                <div class="mt-auto d-flex justify-content-between align-items-center">
                    <span class="badge bg-success">Software Engineering</span>
                    <a href="#" class="btn btn-outline-primary btn-sm">View Full CV</a>
                </div>

            </div>
        </div>
    </div>

    <!-- ===== Junior Software Engineer (UK) ===== -->
    <div class="col-lg-6 col-md-6">
        <div class="card shadow-sm h-100">
            <div class="card-body d-flex flex-column">

                <!-- Header -->
                <div class="d-flex align-items-center mb-3">
                    <div class="rounded-circle bg-secondary text-white d-flex justify-content-center align-items-center me-3"
                         style="width: 48px; height: 48px; font-size: 20px;">
                        JR
                    </div>
                    <div>
                        <h5 class="mb-0">Junior Software Engineer</h5>
                        <small class="text-muted">Match Score: 79%</small>
                    </div>
                </div>

                <!-- CV Preview -->
                <div class="cv-preview mb-3" style="font-size: 0.9rem; max-height: 240px; overflow: hidden;">

                    <h6 class="mb-1 fw-bold">Emily Turner</h6>
                    <p class="mb-2 text-muted">
                        emily.turner@email.co.uk · +44 7400 123456 · Leeds, UK
                    </p>

                    <h6 class="fw-bold">Professional Summary</h6>
                    <p>
                        Enthusiastic Junior Software Engineer with a solid academic background in computer science
                        and hands-on experience through internships. Keen to grow within a collaborative
                        development team.
                    </p>

                    <h6 class="fw-bold">Experience</h6>
                    <ul class="ps-3">
                        <li>
                            <strong>Junior Software Engineer Intern</strong> – BrightApps Ltd, Leeds (Jul 2023 – Sep 2023)
                            <p class="mb-1">
                                Assisted with PHP feature development, frontend bug fixes, and basic API testing.
                            </p>
                        </li>
                    </ul>

                    <h6 class="fw-bold">Education</h6>
                    <ul class="ps-3">
                        <li>BSc (Hons) Computer Science – University of Leeds (2023)</li>
                    </ul>

                    <h6 class="fw-bold">Skills</h6>
                    <ul class="ps-3 mb-0">
                        <li>PHP, MySQL</li>
                        <li>JavaScript, Bootstrap</li>
                        <li>Git, Basic REST APIs</li>
                    </ul>

                </div>

                <!-- Footer -->
                <div class="mt-auto d-flex justify-content-between align-items-center">
                    <span class="badge bg-info text-dark">Junior Software Engineering</span>
                    <a href="#" class="btn btn-outline-primary btn-sm">View Full CV</a>
                </div>

            </div>
        </div>
    </div>

</div>



        </div>
    </div>
</section>