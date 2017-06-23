<?php


namespace Core;


class Application
{
    const FRONTEND_FOLDER = 'frontend';

    public function loadView($templateName, $data = null)
    {
        include self::FRONTEND_FOLDER . DIRECTORY_SEPARATOR . $templateName . '.php';
    }
}