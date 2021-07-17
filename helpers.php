<?php
/**
 * @author Drajat Hasan
 * @email drajathasan20@gmail.com
 * @create date 2021-07-17 21:22:48
 * @modify date 2021-07-17 21:22:48
 * @desc [description]
 */

/**
 * Data dump 
 *
 * @param [type] $mix
 * @param boolean $exit
 * @return void
 */
function dd($mix, bool $exit = true)
{
    echo '<pre>';
    var_dump($mix);
    echo '</pre>';

    if ($exit) exit;
}

function handlerExists(string $handlerNamespace)
{
    return class_exists($handlerNamespace);
}

function savePath($path)
{
    $filteringPath = array_filter(explode(DS, trim($path, DS)), function($stringPath) {
        if (!in_array($stringPath, ['.', '..']))
        {
            return $stringPath;
        }
    });

    return DS . implode(DS, $filteringPath);
}