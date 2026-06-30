<?php

// Application environment:
// Set via $_SERVER['CI_ENVIRONMENT'] or default to development.
define('ENVIRONMENT', $_SERVER['CI_ENVIRONMENT'] ?? 'development');

define('FCPATH', __DIR__ . DIRECTORY_SEPARATOR);

if (getcwd() . DIRECTORY_SEPARATOR !== FCPATH) {
    chdir(FCPATH);
}

require FCPATH . '../vendor/autoload.php';
require FCPATH . '../app/Config/Paths.php';

$paths = new Config\Paths();

require rtrim($paths->systemDirectory, '\\/ ') . DIRECTORY_SEPARATOR . 'Boot.php';

exit(CodeIgniter\Boot::bootWeb($paths));
