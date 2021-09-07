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
if (!function_exists('dd'))
{
    function dd($mix, bool $exit = true)
    {
        echo '<pre>';
        var_dump($mix);
        echo '</pre>';

        if ($exit) exit;
    }
}

function handlerExists(string $handlerNamespace)
{
    return class_exists($handlerNamespace);
}

function isParentSave($path)
{
    $saveParentPath = ['files','images','repository'];
    $filterPath = explode(DS, str_replace(SB, '', $path));

    return (in_array($filterPath[0], $saveParentPath));
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