<?php
/**
 * WordPress View Bootstrapper
 */
if (preg_match('/\/?wp-(.*)$/', $_SERVER["REQUEST_URI"], $matches)) {
    header('Location: https://cyberpur.com');
} elseif (($_SERVER['REQUEST_URI'] == '/club') || (preg_match('/\/?club\/(.*)$/', $_SERVER["REQUEST_URI"], $matches))) {
    header('Location: https://cyberpur.com');
} else {
    define('WP_USE_THEMES', true);
    require __DIR__ . '/nero/wp-blog-header.php';
}
