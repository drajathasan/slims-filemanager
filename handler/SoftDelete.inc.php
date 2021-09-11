<?php
/**
 * @author Drajat Hasan
 * @email drajathasan20@gmail.com
 * @create date 2021-09-11 22:04:58
 * @modify date 2021-09-11 23:39:44
 * @desc [description]
 */

namespace SLiMSFilemanager\Handler;

use SLiMSFilemanager\Action\Http;
use SLiMS\DB;
use \utility as Tool;

class SoftDelete
{
    private $paths;
    private $trashPath;
    private $fail = [];

    public function __construct($paths, $trashPath)
    {
        $this->paths = $paths;
        $this->trashPath = $trashPath;
    }

    private function moveToTrash()
    {
        foreach ($this->paths as $path) {
            $truePath = savePath(SB . $path);
            if (file_exists($truePath))
            {
                $lastPath = array_slice(explode(DS, $path), -1);

                if (isset($lastPath[0]))
                {
                    $type = (is_dir($truePath) ? 'Directory' : 'Files');

                    if (!rename($truePath, $this->trashPath . DS . $lastPath[0])) 
                    {
                        $this->fail[] = $path;
                    }
                    else
                    {
                        $this->writeLog($lastPath[0], $truePath, $type);
                    }
                }
            }
        }
    }

    private function writeLog($name, $path, $type)
    {
        // Write system log
        // Tool::writeLogs($dbs, 'filemanager', 'softDelete', 'filemanager', 'User ' . $_SESSION['uname'] . ' delete file/folder with path ' . $path);
        // Write Filemanager trash dir log
        DB::getInstance()
            ->prepare('insert ignore into filemanagerTrash set name = ?, originalpath = ?, type = ?, deletedat = ?')
            ->execute([$name, $path, $type, date('Y-m-d H:i:s')]);
    }

    public function runProcess()
    {
        $this->moveToTrash();

        Http::jsonResponse(['status' => (count($this->fail) > 0 ? false : true), 'fail' => $this->fail]);
    }
}