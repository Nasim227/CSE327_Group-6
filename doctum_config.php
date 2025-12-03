<?php

use Doctum\Doctum;
use Symfony\Component\Finder\Finder;

$dir = __DIR__;
$iterator = Finder::create()
    ->files()
    ->name('*.php')
    ->in($dir . '/app')
    ->in($dir . '/tests');

return new Doctum($iterator, [
    'title'                => 'CSE327 Project Documentation',
    'build_dir'            => __DIR__ . '/docs/api',
    'cache_dir'            => __DIR__ . '/docs/cache',
    'default_opened_level' => 2,
]);
