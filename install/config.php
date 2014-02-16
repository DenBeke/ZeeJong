<?php
// Add keys and values to the config variable to add them to the installation

$config['SITE_URL'] = 'sprintf(\'%s://%s%s\', isset($_SERVER[\'HTTPS\']) && $_SERVER[\'HTTPS\'] != \'off\' ? \'https\' : \'http\', $_SERVER[\'HTTP_HOST\'], $_SERVER[\'REQUEST_URI\'])';
?>


