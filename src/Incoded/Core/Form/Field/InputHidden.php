<?php
namespace Incoded\Core\Form\Field;

use Incoded\Core\Form\Field\InputText;

class InputHidden extends InputText
{
    public function show($attributes = array(), $namespace = '')
    {
        $attributes['name']  = $namespace == '' ? $this->name : $namespace.'['.$this->name.']';
        $attributes['value'] = $this->value;
        $attributes['id']    = isset($attributes['id']) ? $attributes['id'] : $namespace.'_'.$this->name;

        return sprintf('<input type="hidden"%s/>', implode('', array_map(array($this, 'attributesToHtmlCallback'), array_keys($attributes), array_values($attributes))));
    }
}
?>
