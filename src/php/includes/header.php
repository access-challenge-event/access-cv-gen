<<<<<<< HEAD
=======
<<<<<<< HEAD
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CV Generator - <?php echo get_page_title($page); ?></title>
    
    <!-- Bootstrap 5 CSS from CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        main {
            flex: 1;
        }
        .hero-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 60px 20px;
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold" href="<?php echo get_page_url('home'); ?>">📄 CV Generator</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link <?php echo is_active_page('home'); ?>" href="<?php echo get_page_url('home'); ?>">Home</a></li>
                    <?php if (is_logged_in()): ?>
                    <li class="nav-item"><a class="nav-link <?php echo is_active_page('create'); ?>" href="<?php echo get_page_url('create'); ?>">Create CV</a></li>
                    <li class="nav-item"><a class="nav-link <?php echo is_active_page('my-cvs'); ?>" href="<?php echo get_page_url('my-cvs'); ?>">My CVs</a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            <?php
                            $user = get_current_user_data();
                            echo htmlspecialchars($user['name']);
                            ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="<?php echo get_page_url('logout'); ?>">Logout</a></li>
                        </ul>
                    </li>
                    <?php else: ?>
                    <li class="nav-item"><a class="nav-link <?php echo is_active_page('login'); ?>" href="<?php echo get_page_url('login'); ?>">Login</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
=======
>>>>>>> e9c425a (add my-account and upload-cv pages; update routing and titles)
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CV Generator - <?php echo get_page_title($page); ?></title>
    
    <!-- Bootstrap 5 CSS from CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        main {
            flex: 1;
        }
        .hero-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 60px 20px;
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold" href="<?php echo get_page_url('home'); ?>">📄 CV Generator</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link <?php echo is_active_page('home'); ?>" href="<?php echo get_page_url('home'); ?>">Home</a></li>
<<<<<<< HEAD
                    <?php if (is_logged_in()): ?>
                    <li class="nav-item"><a class="nav-link <?php echo is_active_page('create'); ?>" href="<?php echo get_page_url('create'); ?>">Create CV</a></li>
                    <li class="nav-item"><a class="nav-link <?php echo is_active_page('my-cvs'); ?>" href="<?php echo get_page_url('my-cvs'); ?>">My CVs</a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            <?php
                            $user = get_current_user_data();
                            echo htmlspecialchars($user['name']);
                            ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="<?php echo get_page_url('logout'); ?>">Logout</a></li>
                        </ul>
                    </li>
                    <?php else: ?>
                    <li class="nav-item"><a class="nav-link <?php echo is_active_page('login'); ?>" href="<?php echo get_page_url('login'); ?>">Login</a></li>
                    <?php endif; ?>
=======
                    <li class="nav-item"><a class="nav-link <?php echo is_active_page('create'); ?>" href="<?php echo get_page_url('create'); ?>">Create CV</a></li>
                    <li class="nav-item"><a class="nav-link <?php echo is_active_page('my-cvs'); ?>" href="<?php echo get_page_url('my-cvs'); ?>">My CVs</a></li>
                    <li class="nav-item"><a class="nav-link <?php echo is_active_page('my-account'); ?>" href="<?php echo get_page_url('my-account'); ?>">My Account</a></li>
                    <li class="nav-item"><a class="nav-link <?php echo is_active_page('upload-cv'); ?>" href="<?php echo get_page_url('upload-cv'); ?>">Upload CV</a></li>
>>>>>>> e9c425a (add my-account and upload-cv pages; update routing and titles)
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
<<<<<<< HEAD
=======
>>>>>>> f5d48be (add my-account and upload-cv pages; update routing and titles)
>>>>>>> e9c425a (add my-account and upload-cv pages; update routing and titles)
