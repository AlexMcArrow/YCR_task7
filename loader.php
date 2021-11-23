<?php

define('ROOT_PATH', dirname(__FILE__));

function buildpath(): string
{
    return implode(DIRECTORY_SEPARATOR, func_get_args());
}

spl_autoload_register(function ($class_name): void {
    if (file_exists(buildpath(ROOT_PATH, str_ireplace('\\', DIRECTORY_SEPARATOR, strtolower($class_name))) . '.php')) {
        require buildpath(ROOT_PATH, str_ireplace('\\', DIRECTORY_SEPARATOR, strtolower($class_name))) . '.php';
    } else {
        trigger_error('Error load class: ' . $class_name, E_USER_ERROR);
    }
});
