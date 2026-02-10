<!-- Status Section -->
<section class="py-5 bg-light">
    <div class="container">
        <h2 class="mb-4 text-center">CV Generator</h2>
        <p class="mb-4 text-center">Welcome back, NAME</P>
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

            foreach ($tempJobs as $job)
            {

                //Total number of suggested prospective employees. Should be changed to reflect this from the backend for each role.
                $numOfSuggestedPeople = 6;
                
                ?>
                <div class="col-md-6">
                    <div class="d-flex gap-3">
                        <div>
                            <h5 class=" text-center"><?=$job['title']?></h5>

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