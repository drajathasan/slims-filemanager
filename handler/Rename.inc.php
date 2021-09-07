<?php
/**
 * @author Drajat Hasan
 * @email drajathasan20@gmail.com
 * @create date 2021-07-25 11:41:26
 * @modify date 2021-07-25 11:41:26
 * @desc [description]
 */

namespace SLiMSFilemanager\Handler;

use SLiMSFilemanager\Action\Http;

class Rename
{
    private $path;
    private $file = [];
    private $params = [];
    public function __construct(string $path, array $filenames)
    {
        $customPath = explode(DS, $path);
        unset($customPath[count($customPath) - 1]);
        $this->path = implode(DS, $customPath);
        $this->params = [SB . trim(savePath($this->path), '/') . DS . basename($filenames[0]), SB . trim(savePath($this->path), '/') . DS . basename($filenames[1])];
    }

    private function checkPermission(string $originFile)
    {
        return is_writable($originFile);
    }

    public function runProcess()
    {
        if ($this->checkPermission($this->params[0]))
        {
            $process = call_user_func_array('rename', $this->params);
            Http::jsonResponse(['status' => true, 'msg' => 'Berhasil merubah nama']);
        }
        else
        {
            Http::code(500);
            Http::jsonResponse(['status' => false, 'msg' => 'Gagal merubah, pastikan folder '. SB . $this->path . ' dapat ditulis.']);
        }
        exit;
    }
}