<?php

namespace Entity\Loader;

use Entity\Model\EntityCollection;
use RuntimeException;

class JsonEntityLoader extends ArrayEntityLoader
{
    public function loadFile(EntityCollection $collection, $filename)
    {
        if (!file_exists($filename)) {
            throw new RuntimeException("File not found: " . $filename);
        }
        $json = file_get_contents($filename);
        $data = json_decode($json, true);
        if (!$data) {
            throw new RuntimeException('JSON parse error: ' . json_last_error_msg());
        }
        return $this->loadData($collection, $data);
    }
}
