<?php
/**
 * @author Drajat Hasan
 * @email drajathasan20@gmail.com
 * @create date 2021-07-17 23:48:15
 * @modify date 2021-07-17 23:48:15
 * @desc [description]
 */

namespace SLiMSFilemanager\Action;

class Http
{
    private function __construct()
    {
    }

    public static function fetchRequest()
    {
        $Http = new Http();

        if (method_exists($Http, strtolower($_SERVER['REQUEST_METHOD']).'Request'))
        {
            $Http->{strtolower($_SERVER['REQUEST_METHOD']).'Request'}();
        }
        else
        {
            $Http->jsonResponse(['status' => false, 'message' => 'Method not support!']);
        }
    }

    private function getRequest()
    {
        if (isset($_GET['action']) && handlerExists($namespace = "SLiMSFilemanager\Handler\\".basename($_GET['action'])))
        {
            (new $namespace)->runProcess();
        }
    }

    private function patchRequest()
    {
        $_PATCH = Http::rawInput();

        Http::jsonResponse($_PATCH['test']);
    }

    private function postRequest()
    {

    }

    public static function jsonResponse($mix)
    {
        header('Content-Type: application/json');
        echo json_encode($mix);
        exit;
    }

    public static function rawInput()
    {
        return json_decode(file_get_contents('php://input'), TRUE);
    }
}