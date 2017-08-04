<?php

namespace Entity\Model;

use RuntimeException;

class EntityContainer extends Entity
{
    protected $entities = [];

    public function hasEntity($name)
    {
        return isset($this->entities[$name]);
    }

    public function getEntityTypes()
    {
        $types = [];
        foreach ($this->entities as $entity) {
            $types[$entity->getTypeName()] = $entity->getTypeName();
        }
        return $types;
    }

    public function getEntitiesOfClass($className)
    {
        $res = [];
        foreach ($this->entities as $entity) {
            if (is_a($entity, $className)) {
                $res[$entity->getName()] = $entity;
            }
        }
        return $res;
    }

    public function getEntitiesOfType($typeName)
    {
        $res = [];
        foreach ($this->entities as $entity) {
            if ($entity->getTypeName() == $typeName) {
                $res[$entity->getName()] = $entity;
            }
        }
        return $res;
    }

    public function getEntitiesOfTypeWithLink($typeName, $link, $obj)
    {
        $entities = [];
        foreach ($this->getEntitiesOfType($typeName) as $entity) {
            foreach ($entity->getPropertyValue($link) as $k=>$v) {
                if ($v===$obj)  {
                    $entities[] = $entity;
                }
            }
        }
        return $entities;
    }


    public function getEntity($name)
    {
        if (!$this->hasEntity($name)) {
            throw new RuntimeException("Unknown entity: " . $name);
        }
        return $this->entities[$name];
    }

    public function getEntityOfType($name, $typeName)
    {
        $entity = $this->getEntity($name);
        if ($entity->getTypeName() != $typeName) {
            throw new RuntimeException($entity->getName() . ' is not a ' . $typeName);
        }
        return $entity;
    }

    public function hasEntityOfClass($name, $className)
    {
        if (!$this->hasEntity($name)) {
            return false;
        }
        $entity = $this->getEntity($name);
        return is_a($entity, $className);
    }

    public function addEntity(Entity $e)
    {
        if ($this->hasEntity($e->getName())) {
            throw new RuntimeException("Duplicate entity name: " . $e->getName());
        }
        $this->entities[$e->getName()] = $e;
    }

    public function getEntities()
    {
        return $this->entities;
    }
}
