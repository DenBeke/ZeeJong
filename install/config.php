<?php
$config['SITE_URL'] = 'sprintf(\'%s://%s%s\', isset($_SERVER[\'HTTPS\']) && $_SERVER[\'HTTPS\'] != \'off\' ? \'https\' : \'http\', $_SERVER[\'HTTP_HOST\'], $_SERVER[\'REQUEST_URI\'])';
?>


