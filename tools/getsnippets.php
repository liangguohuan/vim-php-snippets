<?php

include 'Snippet.php';

define('DIR_SRC', '/home/hanson/.vim/bundle/vim-php-manual/manual/doc/');

$filename_snippets = '../snippets/php.snippets';
$count = 0;
foreach ( scandir(DIR_SRC) as $file ) {
    if (in_array($file, ['.', '..']) || strrchr($file, '.') !== '.txt') continue;
    $filename = DIR_SRC . $file;
    $str = Snippet::getStr($filename, false);
    if ($str == '') continue;
    $str = $str . "\n\n";
    file_put_contents($filename_snippets, $str, FILE_APPEND | LOCK_EX);
    /* if ($count > 10) break; */
    $count++;
}

echo 'sucessed!';
