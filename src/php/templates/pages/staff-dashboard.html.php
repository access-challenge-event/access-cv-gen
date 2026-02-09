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
            
            //Probably only eight max for clarity. Placeholder data until hooked up with database.
            //Jobs could appear in order of the soonest to close vs the latest to close.
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
            {

                //Total number of suggested prospective employees. Should be changed to reflect this from the backend for each role.
                $numOfSuggestedPeople = 6;
                
                ?>
                <div class="col-md-6">
                    <div class="d-flex gap-3">
                        <div>
                            <h5><?=$job['title']?></h5>

                            <p class="text-muted">
                                Suggested profiles: <?=$numOfSuggestedPeople?>
                            </p>

                            <!-- The below button should link to the job page of $job -->
                            <a href="/app/staff/LINK_HERE" class="btn btn-primary">
                                View Suggested Profiles
                            </a>

                            <p class="text-muted">
                                At <?=$job['location']?>
                            </p>
                            
                            <p class="text-muted">Skills Required:</p>

                            <ul>
                                <?php
                                foreach ($job['skills'] as $skill)
                                { ?>
                                    <li>
                                        <?=$skill?>
                                    </li>
                                    <?php
                                } ?>
                            </ul>

                            <p class="text-muted">
                                At <?=$job['description']?>
                            </p>
                        </div>
                    </div>
                </div>
            <?php
            } ?>

            
        </div>
    </div>
</section>