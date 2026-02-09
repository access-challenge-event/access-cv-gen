<!-- View CV Page -->
<?php
    $cvContent = $cv['content'] ?? null;
    $cvScore = $cv['score'] ?? null;
    $cvJobTarget = $cv['job_target'] ?? null;
    $cvDate = isset($cv['date_created']) ? date('M j, Y \a\t g:i A', strtotime($cv['date_created'])) : null;
?>
<section class="py-4">
    <div class="container">
        <div class="row">
            <div class="col-lg-10 mx-auto">
                <!-- Controls -->
                <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 no-print">
                    <div>
                        <h1 class="h3 mb-1">Your Generated CV</h1>
                        <?php if ($cvDate): ?>
                            <p class="text-muted mb-0">Created <?php echo $cvDate; ?></p>
                        <?php else: ?>
                            <p class="text-muted mb-0">Review your CV below, then download or print.</p>
                        <?php endif; ?>
                    </div>
                    <div class="d-flex gap-2 flex-wrap">
                        <?php if ($cvScore !== null): ?>
                            <?php
                                $scoreClass = 'secondary';
                                if ($cvScore >= 70) $scoreClass = 'success';
                                elseif ($cvScore >= 50) $scoreClass = 'warning';
                                else $scoreClass = 'danger';
                            ?>
                            <span class="btn btn-<?php echo $scoreClass; ?> disabled">
                                Score: <?php echo $cvScore; ?>/100
                            </span>
                        <?php endif; ?>
                        <button type="button" class="btn btn-outline-secondary" onclick="window.print()">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="me-1" viewBox="0 0 16 16">
                                <path d="M2.5 8a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1z"/>
                                <path d="M5 1a2 2 0 0 0-2 2v2H2a2 2 0 0 0-2 2v3a2 2 0 0 0 2 2h1v1a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2v-1h1a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-1V3a2 2 0 0 0-2-2H5zM4 3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v2H4V3zm1 5a2 2 0 0 0-2 2v1H2a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-1v-1a2 2 0 0 0-2-2H5zm7 2v3a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1z"/>
                            </svg>
                            Print
                        </button>
                        <button type="button" class="btn btn-primary" id="downloadPdfBtn">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="me-1" viewBox="0 0 16 16">
                                <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z"/>
                                <path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z"/>
                            </svg>
                            Download PDF
                        </button>
                        <a href="<?php echo get_page_url('my-cvs'); ?>" class="btn btn-outline-primary">
                            My CVs
                        </a>
                        <a href="<?php echo get_page_url('create'); ?>" class="btn btn-outline-secondary">
                            Create New
                        </a>
                    </div>
                </div>

                <?php if ($cvJobTarget): ?>
                    <div class="alert alert-info mb-4 no-print">
                        <strong>Target Role:</strong> <?php echo htmlspecialchars($cvJobTarget); ?>
                    </div>
                <?php endif; ?>

                <!-- No CV Message -->
                <div id="no-cv-message" class="alert alert-warning" style="display:none;">
                    <h5 class="alert-heading">No CV Found</h5>
                    <p class="mb-0">It looks like you haven't generated a CV yet or the CV was not found. Please go back to the Create CV page and generate one.</p>
                    <hr>
                    <a href="<?php echo get_page_url('create'); ?>" class="btn btn-warning">Go to Create CV</a>
                </div>

                <!-- CV Document -->
                <div id="cv-document" class="card shadow-sm" <?php if (!$cvContent): ?>style="display:none;"<?php endif; ?>>
                    <div class="card-body p-4 p-md-5 bg-white" id="cv-content">
                        <?php if ($cvContent): ?>
                            <?php echo $cvContent; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- html2pdf.js library for PDF generation -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>

<style>
    /* CV Document Styling */
    #cv-content {
        font-family: 'Georgia', 'Times New Roman', serif;
        line-height: 1.6;
        color: #333;
    }

    #cv-content h1 {
        font-size: 2rem;
        margin-bottom: 0.5rem;
        color: #1a1a1a;
        border-bottom: 2px solid #333;
        padding-bottom: 0.5rem;
    }

    #cv-content h2 {
        font-size: 1.4rem;
        margin-top: 1.5rem;
        margin-bottom: 0.75rem;
        color: #2c3e50;
        border-bottom: 1px solid #bdc3c7;
        padding-bottom: 0.3rem;
    }

    #cv-content h3 {
        font-size: 1.1rem;
        margin-top: 1rem;
        margin-bottom: 0.5rem;
        color: #34495e;
    }

    #cv-content p {
        margin-bottom: 0.75rem;
    }

    #cv-content ul {
        margin-bottom: 1rem;
        padding-left: 1.5rem;
    }

    #cv-content li {
        margin-bottom: 0.4rem;
    }

    /* Print styles */
    @media print {
        .no-print {
            display: none !important;
        }

        .card {
            border: none !important;
            box-shadow: none !important;
        }

        #cv-content {
            padding: 0 !important;
        }

        body {
            background: white !important;
        }

        nav, footer {
            display: none !important;
        }
    }
</style>

<script>
(function() {
    var cvContent = document.getElementById('cv-content');
    var cvDocument = document.getElementById('cv-document');
    var noCvMessage = document.getElementById('no-cv-message');
    var downloadBtn = document.getElementById('downloadPdfBtn');

    // Check if CV content exists from PHP
    var hasServerContent = <?php echo $cvContent ? 'true' : 'false'; ?>;

    if (!hasServerContent) {
        // Try to retrieve CV from session storage (for newly generated CVs before redirect)
        var generatedCV = sessionStorage.getItem('generatedCV');
        var cvName = sessionStorage.getItem('generatedCVName') || 'CV';

        if (generatedCV) {
            cvContent.innerHTML = generatedCV;
            cvDocument.style.display = '';
            noCvMessage.style.display = 'none';
            // Clear session storage after loading
            sessionStorage.removeItem('generatedCV');
            sessionStorage.removeItem('generatedCVName');
        } else {
            cvDocument.style.display = 'none';
            noCvMessage.style.display = '';
            downloadBtn.disabled = true;
        }
    }

    // PDF Download
    downloadBtn.addEventListener('click', function() {
        var element = cvContent;
        var filename = 'CV_' + new Date().toISOString().slice(0, 10) + '.pdf';

        var opt = {
            margin: [10, 10, 10, 10],
            filename: filename,
            image: { type: 'jpeg', quality: 0.98 },
            html2canvas: {
                scale: 2,
                useCORS: true,
                letterRendering: true
            },
            jsPDF: {
                unit: 'mm',
                format: 'a4',
                orientation: 'portrait'
            },
            pagebreak: { mode: ['avoid-all', 'css', 'legacy'] }
        };

        // Show loading state
        var originalText = downloadBtn.innerHTML;
        downloadBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-1" role="status"></span> Generating PDF...';
        downloadBtn.disabled = true;

        html2pdf().set(opt).from(element).save().then(function() {
            downloadBtn.innerHTML = originalText;
            downloadBtn.disabled = false;
        }).catch(function(err) {
            console.error('PDF generation error:', err);
            downloadBtn.innerHTML = originalText;
            downloadBtn.disabled = false;
            alert('Error generating PDF. Please try printing instead.');
        });
    });
})();
</script>
