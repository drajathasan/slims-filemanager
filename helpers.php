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

function createSysconf()
{
    global $sysconf,$dbs;

    if (!isset($sysconf['filemanager']))
    {
        $Data = [
            'canDownload' => true,
            'trashDir' => __DIR__ . DS . 'trash'
        ];

        $dbs->query('insert into setting set setting_name = \'filemanager\', setting_value = \'' . serialize($Data) . '\'');
    }

    if ($dbs->query('show tables like \'filemanagerTrash\'')->num_rows === 0)
    {
        $dbs->query('CREATE TABLE `filemanagerTrash` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `name` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
            `originalpath` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
            `type` enum(\'Files\',\'Directory\') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
            `deletedat` datetime DEFAULT NULL ON UPDATE current_timestamp(),
            PRIMARY KEY (`id`),
            UNIQUE KEY `name` (`name`) USING HASH
            ) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;');
    }
}