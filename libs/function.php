<?php
/**
 * Autoload class function
 */
function __autoload($class)
{
    $path = "libs/{$class}.php";
    if (file_exists($path))
    {
        require_once ($path);
    }
    else
    {
        die ("File {$class} not found!");
    }
}

?>
