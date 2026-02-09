<?php
/**
 * Google OAuth callback handler
 *
 * Handles two stages of the OAuth flow:
 * 1. No 'code' param → redirect to Google for authorization
 * 2. 'code' param present → exchange for token, fetch profile, log in user
 */

$provider = get_google_provider();

// Stage 1: Redirect to Google
if (!isset($_GET['code'])) {
    $authUrl = $provider->getAuthorizationUrl([
        'scope' => ['openid', 'email', 'profile'],
    ]);
    $_SESSION['oauth2state'] = $provider->getState();
    header('Location: ' . $authUrl);
    exit;
}

// Stage 2: Verify state and exchange code for token
if (empty($_GET['state']) || ($_GET['state'] !== ($_SESSION['oauth2state'] ?? ''))) {
    unset($_SESSION['oauth2state']);
    header('Location: ?page=login');
    exit;
}

try {
    $token = $provider->getAccessToken('authorization_code', [
        'code' => $_GET['code'],
    ]);

    $googleUser = $provider->getResourceOwner($token);
    $profile = $googleUser->toArray();

    $user = find_or_create_user(
        $profile['sub'],
        $profile['email'],
        $profile['name'],
        $profile['picture'] ?? null
    );

    $_SESSION['user'] = $user;
    unset($_SESSION['oauth2state']);

    header('Location: ?page=home');
    exit;
} catch (Exception $e) {
    // On error, redirect to login with a generic message
    $_SESSION['login_error'] = 'Authentication failed. Please try again.';
    header('Location: ?page=login');
    exit;
}
