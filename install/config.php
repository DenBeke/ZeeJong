<?php
// Add keys and values to the config variable to add them to the installation

function get_base_url()
{
    /* First we need to get the protocol the website is using */
    $protocol = strtolower(substr($_SERVER["SERVER_PROTOCOL"], 0, 5)) == 'https' ? 'https://' : 'http://';

    /* returns /myproject/index.php */
    $path = $_SERVER['PHP_SELF'];

    /*
    * returns an array with:
    * Array (
    *  [dirname] => /myproject/
    *  [basename] => index.php
    *  [extension] => php
    *  [filename] => index
    * )
    */
    $path_parts = pathinfo($path);
    $directory = $path_parts['dirname'];
    /*
    * If we are visiting a page off the base URL, the dirname would just be a "/",
    * If it is, we would want to remove this
    */
    $directory = ($directory == "/") ? "" : $directory;

    /* Returns localhost OR mysite.com */
    $host = $_SERVER['HTTP_HOST'];

    /*
    * Returns:
    * http://localhost/mysite
    * OR
    * https://mysite.com
    */
    return $protocol . $host . $directory;
}

function get_install_dir()
{
    $path = $_SERVER['PHP_SELF'];
    $path_parts = pathinfo($path);
    $directory = $path_parts['dirname'];
    return $directory;
}

$config['SITE_URL'] = '\'' . substr(get_base_url(), 0, strlen(get_base_url()) - strlen('install') ) . '\'';
$config['INSTALL_DIR'] = '\'' . substr(get_install_dir(), 0, strlen(get_install_dir()) - strlen('install')) . '\'';

$config['THEME_DIR'] = 'dirname(__FILE__) . \'/../theme\'';

?>


