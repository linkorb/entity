<?php

namespace Entity\Loader;

use Entity\Model\EntityContainer;
use Symfony\Component\Yaml\Yaml;
use RuntimeException;

class YamlEntityLoader extends ArrayEntityLoader
{
    public function loadFile(EntityContainer $container, $filename)
    {
        if (!file_exists($filename)) {
            throw new RuntimeException("File not found: " . $filename);
        }
        $yaml = file_get_contents($filename);
        $data = Yaml::parse($yaml);
        if (!$data) {
            throw new RuntimeException('Yaml parse error');
        }
        return $this->loadData($container, $data);
    }
}
