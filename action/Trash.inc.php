<?php
/**
 * @author Drajat Hasan
 * @email drajathasan20@gmail.com
 * @create date 2021-07-17 20:56:49
 * @modify date 2021-09-12 13:50:21
 * @desc [description]
 */

namespace SLiMSFilemanager\Action;
use SLiMS\DB;

class Trash extends LoadContent
{
    private $bin = [];
    
    private function __construct($Trashpath)
    {
        parent::__construct($Trashpath);
    }

    private function matching()
    {
        // add execption
        array_push($this->pathException, '.gitkeep');

        // Load Ddatabase Instance
        $DB = DB::getInstance();

        // Trash Directory
        $TrashDirectory = $this->loadDir()->result();

        // Load data from database
        $TrashData = $DB->query('select * from filemanagerTrash');

        $Result = [];
        while ($Data = $TrashData->fetch(\PDO::FETCH_ASSOC)) { 
            foreach ($TrashDirectory as $index => $TrashDir) {
                if ($Data['name'] === $TrashDir['name'])
                {
                    $Result[] = $TrashDir;
                }
            }
        }

        if ($TrashData->rowCount())
        {
            $this->bin = $Result;
        }
    }

    public function bin()
    {
        $this->matching();
        return $this->bin;
    }

    public static function init()
    {
        global $sysconf;

        return (new Trash($sysconf['filemanager']['trashDir']));
    }
}