<?php
/**
 * @author Drajat Hasan
 * @email drajathasan20@gmail.com
 * @create date 2021-07-17 20:56:49
 * @modify date 2021-07-17 20:56:49
 * @desc [description]
 */

namespace SLiMSFilemanager\Action;

class LoadContent
{
    private $dirLocation;
    private $metaFileInDir = [];
    public $pathException = ['.','..'];

    public function __construct(string $dir = __DIR__)
    {
        $this->dirLocation = $dir;
    }

    public function setDirectoryLocation($dir)
    {
        $this->dirLocation = $dir;
    }

    public function getDirectoryLocation()
    {
        return $this->getRootPath($this->dirLocation);
    }

    private function calc(int $filesize, int $decimals = 2)
    {
        // Took from
        // https://www.php.net/manual/en/function.filesize.php#106569
        $sz = 'BKMGTP';
        $factor = floor((strlen($filesize) - 1) / 3);
        return sprintf("%.{$decimals}f", $filesize / pow(1024, $factor)) . @$sz[$factor];
    }

    private function convertDate(int $inputDate)
    {
        return date('D, d M Y', $inputDate);
    }

    private function getRootPath(string $originPath)
    {
        return trim(str_replace(SB, '', $originPath), DS);
    }

    private function getIconName(string $path)
    {
        if (is_dir($path))
        {
            return 'folder.svg';
        }

        $meta = pathinfo($path);

        return (isset($meta['extension']) && file_exists(__DIR__ . DS . '..' .DS. 'assets' . DS . strtolower($meta['extension']) . '.svg')) ? strtolower($meta['extension']) . '.svg' : 'file.svg';
    }

    public function loadDir()
    {
        if (file_exists($this->dirLocation))
        {
            $dir = array_values(array_filter(scandir($this->dirLocation), function($content){
                    if (!in_array($content, $this->pathException)) 
                    {
                        $this->metaFileInDir[] = [
                            'path' => $this->getRootPath($this->dirLocation . DS . $content),
                            'type' => (is_dir($this->dirLocation . DS . $content)) ? 'directory' : 'file',
                            'name' => $content,
                            'size' => $this->calc(filesize($this->dirLocation . DS . $content)),
                            'dateCreated' => $this->convertDate(filectime($this->dirLocation . DS . $content)),
                            'dateModified' => $this->convertDate(filemtime($this->dirLocation . DS . $content)),
                            'icon' => $this->getIconName($this->dirLocation . DS . $content)
                        ];
                    }
            }));
        }

        return $this;
    }

    public function result()
    {
        return $this->metaFileInDir;
    }
}