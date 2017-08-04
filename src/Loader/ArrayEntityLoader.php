<?php

namespace Entity\Loader;

use Entity\Model\EntityContainer;
use Entity\Model\EntityType;
use Entity\Model\Entity;
use RuntimeException;
use Doctrine\Common\Inflector\Inflector;

abstract class ArrayEntityLoader
{
    public function loadData(EntityContainer $container, $data)
    {
        foreach ($data as $typeName => $entitiesData) {
            if ($typeName[0]!='_') {
                $type = new EntityType($typeName);

                foreach ($entitiesData as $entityName => $entityData) {
                    $entity = new Entity($type, $entityName);
                    $container->addEntity($entity);
                    if ($entityData) {
                        foreach ($entityData as $k => $v) {
                            // process references (@)
                            if (is_array($v)) {
                                //$adder = 'add' . Inflector::classify($k);
                                $vProcessed = [];
                                foreach ($v as $k2=>$v2) {
                                    if ($v2[0]=='@') {
                                        $v2 = $container->getEntity(substr($v2,1));
                                        //$adder2 = 'add' . Inflector::classify($entity->getTypeName());
                                        //$v2->$adder2($entity);
                                    }
                                    //$entity->$adder($v2);
                                    $entity->addPropertyValue($k, $v2);
                                }
                            } else {
                                //$setter = 'set' . Inflector::classify($k);
                                $entity->setPropertyValue($k, $v);
                            }
                        }
                    }
                }
            }
        }

        return $container;
    }
}
