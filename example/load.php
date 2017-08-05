<?php

require_once(__DIR__ . '/../vendor/autoload.php');

$loader = new \Entity\Loader\AutoEntityLoader();
$collection = $loader->autoload();
print_r($collection);


// List all entities
echo "\n--- Entities: ---\n";
foreach ($collection as $entity) {
    echo $entity->getName() . ' (' . $entity->getEntityType()->getName() . ")\n";
}


// List all entities by type
echo "\n--- Genres: ---\n";
foreach ($collection->getAllByType('genre') as $entity) {
    echo $entity->getName() . ' ';
}
echo "\n--- Details: ---\n";
$entity = $collection->get('hackers');
echo "Name: " . $entity->getName();
foreach ($entity->getPropertyValues() as $k=>$v) {
    echo $k .='=';
    if (ctype_alnum($v)) {
        echo $v;
    }
    if (is_array($v)) {
        foreach ($v as $k2 => $v2) {
            echo "@" . $v2->getName() . " ";
        }
    }
    echo "\n";
}
echo "\n";

exit("Done\n");
