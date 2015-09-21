<?php
namespace Incoded\Core\Form\Field;

use Incoded\Core\Form\Field\Field;

class Select extends Field
{
    public $values;

    public function __construct($name, $value = '', $values = array(), $options = array())
    {
        $this->name    = $name;
        $this->value   = $value;
        $this->values  = $values;
        $this->options = $options;
    }

    public function show($attributes = array(), $namespace = '')
    {
        $attributes['name']   = $namespace == '' ? $this->name : $namespace.'['.$this->name.']';
        $attributes['id']     = isset($attributes['id']) ? $attributes['id'] : ($namespace != '' ? $namespace.'_'.$this->name : $this->name);

        $options = $this->getSelectOptions($this->values, $this->value);

        return sprintf('<select%s>%s</select>', implode('', array_map(array($this, 'attributesToHtmlCallback'), array_keys($attributes), array_values($attributes))), "\n".implode("\n", $options)."\n");
    }

    protected function getSelectOptions($values, $selected_value = '')
    {
        $selected   = false;
        $options    = array();
        $attributes = array();
        $attributes['selected'] = 'selected';

        if (isset($this->options['empty_option']) && $this->options['empty_option'] !== false)
        {
            array_unshift($values, $this->options['empty_option']);
        }

        foreach ($values as $value => $label)
        {
            $attributes['value'] = $value;

            unset($attributes['selected']);
            if (!$selected && ($selected_value == '' || $value == $selected_value))
            {
                $attributes['selected'] = 'selected';
                $selected = true;
            }

            $options[] = sprintf('<option%s>%s</option>', implode('', array_map(array($this, 'attributesToHtmlCallback'), array_keys($attributes), array_values($attributes))), $label);
        }

        return $options;
    }

    protected function attributesToHtmlCallback($k, $v)
    {
        return false === $v || null === $v || ('' === $v && 'value' != $k) ? '' : sprintf(' %s="%s"', $k, $v);
    }
}
?>
