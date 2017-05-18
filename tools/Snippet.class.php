<?php

class Snippet
{
    function __construct()
    {
        
    }
    public static function addPosToParam($arr, $count = 0)
    {
        $arr_new = array_map(function($v) use (&$count) {
            $v = trim($v);
            $count++;
            return '${' . $count . ':' . $v . '}';
        }, $arr);
        return $arr_new;
    }

    public static function getStr($filename, $bopt = false)
    {
        // $fname = 'str_replace';
        /* $url = 'http://il1.php.net/manual/zh/function.' . str_replace('_', '-', $fname) . '.php'; */
        /* $content = file_get_contents($url); */
        /* preg_match_all('/<div class="methodsynopsis dc\-description">(.*?)<\/div>/msi', $content, $match); */
        /* $str = strip_tags($match[1][0]); */
        /* $str = htmlspecialchars_decode($str, ENT_QUOTES); */

        /* $filename = '/home/hanson/.vim/bundle/vim-php-manual/manual/doc/str-replace.txt'; */
        $fname = basename($filename);
        $fname = str_replace(['.txt', '-'], ['', '_'], $fname);
        $content = file_get_contents($filename);
        preg_match_all('/\*Description\*[^\w]+([^)]*\))~/ms', $content, $match);

        /* ignore function alias */
        if (!isset($match[1][0])) {
             return '';
        }

        $str = $match[1][0];
        $str = preg_replace("/[\n]/", '', $str);
        $str = str_replace('~', '', $str);
        /* return 'function: ' . $str; */

        //变量初始化
        $strreq = '';
        $stropt = '';
        $arropt = $arrreq = null;

        $str = substr( $str, strpos($str, '('), strrpos($str, ')') );
        $str = str_replace('~    ', '', $str);
        $strdesc = preg_replace('/\s+/', ' ', $str);
        preg_match_all('/(\[,?(.*)\])/', $str, $match);
        if (!empty($match[1][0])) {
            $stropt = $match[1][0];
            $str = str_replace($stropt, '', $str);
        }

        $str = trim($str);
        preg_match_all('/\((.*?)\)/', $str, $match);
        $strreq = trim($match[1][0]);
        $strreq && $arrreq = explode(',', $strreq);
        $arrreq && $arrreq = self::addPosToParam($arrreq);
        $arrreq && $strreq = implode(', ', $arrreq);
        if ($bopt) {
            $arropt = preg_split('/\s*\[,/', $stropt, -1, PREG_SPLIT_NO_EMPTY);
            //补上'[, '
            array_walk($arropt, function(&$v, $k) {
                $v = '[, ' . trim($v);
            });
            $arropt && $arropt = self::addPosToParam($arropt, count($arrreq));
            $arropt && $stropt = implode('', $arropt);
        } else {
            $stropt = '';
        }
        $strallparam = $strreq . $stropt;
$ret = <<<EOF
snippet ${fname}
	${fname}(${strallparam})\${0}
EOF;
        return $ret;
    }
}
        


