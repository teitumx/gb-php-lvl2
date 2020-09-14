<?php

class Autoload
{
    // const DIRS = [
    //     'models', 'services'
    // ];

    // public function load($className)
    // {   
    //     foreach (static::DIRS as $dir) {
    //         $fileName = dirname(__DIR__) . "/{$dir}/{$className}.php";
    //         if(file_exists($fileName)){
    //             include $fileName;
    //         break;
    //         }
    //     }

    // }

    public function myautoload($className)
    {
        $classPart = explode('\\', $className);
        switch ($classPart[0]) {
            case 'models':
                include __DIR__ . '../' . implode(DIRECTORY_SEPARATOR, $classPart) . '.php';
                break;
            case 'services':
                include __DIR__ . './' . implode(DIRECTORY_SEPARATOR, $classPart) . '.php';
        }
    }
}
