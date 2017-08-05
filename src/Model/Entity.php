<?php

namespace Entity\Model;

use Doctrine\Common\Inflector\Inflector;
use Collection\Identifiable;
use ReflectionClass;

class Entity implements Identifiable
{
    protected $name;
    protected $type;
    protected $properties = [];

    protected $container;

    public function __construct(EntityType $type, $name)
    {
        $this->type = $type;
        $this->name = $name;
    }

    public function getEntityType()
    {
        return $this->type;
    }

    public function getTypeName()
    {
        return $this->type->getName();
    }

    public function getName()
    {
        return $this->name;
    }

    public function getContainer()
    {
        return $this->container;
    }

    public function setContainer(EntityContainer $container)
    {
        $this->container = $container;
        return $this;
    }

    public function getPropertyValues()
    {
        return $this->properties;
    }

    public function setPropertyValue($name, $value)
    {
        $this->properties[$name] = $value;
    }

    public function hasProperty($name)
    {
        return isset($this->properties[$name]);
    }

    public function addPropertyValue($name, $value)
    {
        if (!isset($this->properties[$name])) {
            $this->properties[$name] = [];
        }
        $this->properties[$name][] = $value;
    }

    public function getPropertyValue($name)
    {
        if (!$this->hasProperty($name)) {
            return null;
        }
        return $this->properties[$name];
    }

    public function identifier()
    {
        return $this->getName();
    }

}
