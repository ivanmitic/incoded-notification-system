<?php
namespace Incoded\Core\Form\Field;

abstract class Field
{
    public
        $name,
        $value,
        $options;

    public function __toString()
    {
        return $this->show();
    }

    abstract public function show($attributes = array(), $namespace = '');

    public function setValue($value)
    {
        $this->value = $value;
    }

    public function getValue()
    {
        return $this->value;
    }
}
?>
