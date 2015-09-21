<?php
namespace Incoded\Core\Form\Field;

use Incoded\Core\Form\Field\Field;

class Textarea extends Field
{
    public function __construct($name, $value = '', $options = array())
    {
        $this->name    = $name;
        $this->value   = $value;
        $this->options = $options;
    }

    public function show($attributes = array(), $namespace = '')
    {
        $attributes['name'] = $namespace == '' ? $this->name : $namespace.'['.$this->name.']';
        $attributes['id']   = isset($attributes['id']) ? $attributes['id'] : $namespace.'_'.$this->name;

        return sprintf('<textarea%s>%s</textarea>', implode('', array_map(array($this, 'attributesToHtmlCallback'), array_keys($attributes), array_values($attributes))), $this->value);
    }

    protected function attributesToHtmlCallback($k, $v)
    {
        return false === $v || null === $v || ('' === $v && 'value' != $k) ? '' : sprintf(' %s="%s"', $k, $v);
    }
}
?>
