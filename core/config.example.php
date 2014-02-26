<?php
DEFINE('SITE_URL', sprintf('%s://%s%s', isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http', $_SERVER['HTTP_HOST'], $_SERVER['REQUEST_URI']));
DEFINE('DB_HOST', '127.0.0.1');
DEFINE('DB_PORT', '');
DEFINE('DB_USER', '');
DEFINE('DB_PASS', '');
DEFINE('DB_NAME', 'zeejong');
?>
