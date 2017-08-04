<?php

namespace Entity\Loader;

use Entity\Model\EntityContainer;
use RuntimeException;

class JsonEntityLoader extends ArrayEntityLoader
{
    public function loadFile(EntityContainer $container, $filename)
    {
        if (!file_exists($filename)) {
            throw new RuntimeException("File not found: " . $filename);
        }
        $json = file_get_contents($filename);
        $data = json_decode($json, true);
        if (!$data) {
            throw new RuntimeException('JSON parse error: ' . json_last_error_msg());
        }
        return $this->loadData($container, $data);
    }
}
