<?php
/**
 * Autoloader for index.php
 */
spl_autoload_register (
    function ($class) {
        require_once('functions.php');
        require_once('classes/TenableDB.php');
});
