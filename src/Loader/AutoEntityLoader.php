<?php

namespace Entity\Loader;

use Entity\Model\EntityType;
use Entity\Model\EntityCollection;
use RuntimeException;

class AutoEntityLoader extends ArrayEntityLoader
{
    public function autoload()
    {
        $baseDir = getcwd();

        $type = new EntityType('root');
        $container = new EntityCollection($type, 'root');

        $filename = $baseDir . '/entities.json';
        if (file_exists($filename)) {
            $loader = new JsonEntityLoader();
            return $loader->loadFile($container, $filename);
        }

        $filename = $baseDir . '/entities.yml';
        if (file_exists($filename)) {
            $loader = new YamlEntityLoader();
            return $loader->loadFile($container, $filename);
        }

        throw new RuntimeException("Missing entity configuration");
    }
}
