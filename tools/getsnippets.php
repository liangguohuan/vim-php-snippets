<?php

include 'Snippet.class.php';

define('DIR_SRC', sprintf('%s/.vim/bundle/vim-php-manual/manual/doc/', getenv('HOME')));

$filename_rules = './ignore_rules.txt';
$filename_snippets = '../snippets/php.snippets';

// unlink file
unlink($filename_snippets);

// get ruls to array
$str_rules = file_get_contents($filename_rules);
$arr_rule = preg_split('/[\r\n]/', $str_rules);

// scan files to handle
$count = 0;
foreach ( scandir(DIR_SRC) as $file ) {
    if (in_array($file, ['.', '..']) || strrchr($file, '.') !== '.txt') continue;
    if (check_rule($file, $arr_rule)) continue; 

    $filename = DIR_SRC . $file;
    $str = Snippet::getStr($filename, false);
    if ($str == '') continue;
    $str = $str . "\n\n";
    file_put_contents($filename_snippets, $str, FILE_APPEND | LOCK_EX);
    /* if ($count > 10) break; */
    $count++;
}

echo "sucessed!\n";

function check_rule($file, $arr_rule)
{
    foreach ($arr_rule as $rule) {
        $rule = preg_quote($rule);
        if ($rule != '' && preg_match("/^{$rule}/", $file)) {
            return true;
        }

    }
    return false;
}
