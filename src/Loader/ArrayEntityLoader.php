<?php

namespace Entity\Loader;

use Entity\Model\EntityCollection;
use Entity\Model\EntityType;
use Entity\Model\Entity;
use RuntimeException;
use Doctrine\Common\Inflector\Inflector;

abstract class ArrayEntityLoader
{
    public function loadData(EntityCollection $collection, $data)
    {
        foreach ($data as $typeName => $entitiesData) {
            if ($typeName[0]!='_') {
                $type = new EntityType($typeName);

                foreach ($entitiesData as $entityName => $entityData) {
                    $entity = new Entity($type, $entityName);
                    $collection->add($entity);
                    if ($entityData) {
                        foreach ($entityData as $k => $v) {
                            // process references (@)
                            if (is_array($v)) {
                                $vProcessed = [];
                                foreach ($v as $k2=>$v2) {
                                    if ($v2[0]=='@') {
                                        $linkKey = substr($v2,1);
                                        if (!$collection->hasKey($linkKey)) {
                                            throw new RuntimeException("Linking to unknown key: " . $linkKey);
                                        }
                                        $v2 = $collection->get($linkKey);
                                    }
                                    $entity->addPropertyValue($k, $v2);
                                }
                            } else {
                                $entity->setPropertyValue($k, $v);
                            }
                        }
                    }
                }
            }
        }

        return $collection;
    }
}
