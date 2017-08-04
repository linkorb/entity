<?php

require_once(__DIR__ . '/../vendor/autoload.php');

$loader = new \Entity\Loader\AutoEntityLoader();
$container = $loader->autoload();
print_r($container);


// List all entities
echo "\n--- Entities: ---\n";
foreach ($container->getEntities() as $entity) {
    echo $entity->getName() . ' (' . $entity->getEntityType()->getName() . ")\n";
}


// List all entities by type
echo "\n--- Genres: ---\n";
foreach ($container->getEntitiesOfType('genre') as $entity) {
    echo $entity->getName() . ' ';
}
echo "\n--- Details: ---\n";
$entity = $container->getEntity('hackers');
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
