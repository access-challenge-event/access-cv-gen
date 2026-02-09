<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="display-4 fw-bold mb-3">Dashboard</h1>
                <p class="lead mb-4">
                    Generate beautiful, AI-enhanced CVs with the power of Gemini. 
                    Highlight your skills, experience, and education effortlessly.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Status Section -->
<section class="py-5 bg-light">
    <div class="container">
        <h2 class="mb-4 text-center">Dashboard</h2>
    </div>
</section>

<!-- Features Section CONTINUE FROM HERE-->
<section class="py-5">
    <div class="container">
        <h2 class="mb-5 text-center">Jobs Closing Soon</h2>
        <div class="row g-4">

            <?php
            //probably only four. temporary data until hooked up with database
            $tempJobs = [
                [
                    "role" => "Job One",
                    "location" => "Northampton",
                    "skills" => [
                        "Skill 1",
                        "Skill 2",
                        "Skill 3",
                        "Skill 4"
                    ],
                    "description" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum."
                ],
                [
                    "role" => "Job Two",
                    "location" => "Northampton",
                    "skills" => [
                        "Skill 1",
                        "Skill 2",
                        "Skill 3",
                        "Skill 4"
                    ],
                    "description" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum."
                ],
                [
                    "role" => "Job Three",
                    "location" => "Northampton",
                    "skills" => [
                        "Skill 1",
                        "Skill 2",
                        "Skill 3",
                        "Skill 4"
                    ],
                    "description" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum."
                ],
                [
                    "role" => "Job Four",
                    "location" => "Northampton",
                    "skills" => [
                        "Skill 1",
                        "Skill 2",
                        "Skill 3",
                        "Skill 4"
                    ],
                    "description" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum."
                ]
            ];

            foreach ($tempJobs as $job)
            { ?>
                <div class="col-md-6">
                    <div class="d-flex gap-3">
                        <div>
                            <!-- CONTINUE HERE -->
                            <h5>JOB TITLE</h5>
                            <p class="text-muted">
                                Leverage Gemini API to create compelling CV content tailored to your profile.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="d-flex gap-3">
                        <div>
                            <h5>Responsive Design</h5>
                            <p class="text-muted">Beautiful, responsive layouts that look great on any device or screen size.</p>
                        </div>
                    </div>
                </div>
            <?php
            } ?>

            
        </div>
    </div>
</section>