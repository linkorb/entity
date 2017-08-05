<?php

namespace Entity\Model;

use RuntimeException;

class EntityCollection extends \Collection\TypedArray
{
    public function __construct()
    {
        $this->className = Entity::class;
    }

    public function getUniqueTypes()
    {
        $types = [];
        foreach ($this->items as $item) {
            $types[$item->getTypeName()] = $item->getTypeName();
        }
        return $types;
    }

    public function getAllByClass($className)
    {
        $res = [];
        foreach ($this->items as $item) {
            if (is_a($item, $className)) {
                $res[$item->getName()] = $item;
            }
        }
        return $res;
    }

    public function getAllByType($typeName)
    {
        $res = [];
        foreach ($this->items as $item) {
            if ($item->getTypeName() == $typeName) {
                $res[$item->getName()] = $item;
            }
        }
        return $res;
    }

    public function getAllByTypeAndLink($typeName, $link, $obj)
    {
        $entities = [];
        foreach ($this->getEntitiesOfType($typeName) as $item) {
            foreach ($item->getPropertyValue($link) as $k=>$v) {
                if ($v===$obj)  {
                    $entities[] = $item;
                }
            }
        }
        return $entities;
    }

    public function getOneWithType($name, $typeName)
    {
        $item = $this->getEntity($name);
        if ($item->getTypeName() != $typeName) {
            throw new RuntimeException($item->getName() . ' is not a ' . $typeName);
        }
        return $item;
    }
}
