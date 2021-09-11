<?php
/**
 * @author Drajat Hasan
 * @email drajathasan20@gmail.com
 * @create date 2021-07-17 23:58:15
 * @modify date 2021-07-17 23:58:15
 * @desc [description]
 */

namespace SLiMSFilemanager\Handler;

use SLiMSFilemanager\Action\LoadContent;
use SLiMSFilemanager\Action\Http;

class GetDir extends LoadContent
{
    public function runProcess()
    {
        $path = SB . $_GET['path'];

        if (!isParentSave($path))
        {
            Http::jsonResponse([]);
        }
        else
        {
            parent::__construct(savePath($path));
            Http::jsonResponse($this->loadDir()->result());
        }
    }   
}