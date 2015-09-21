<?php
namespace Incoded\Core\Form\Field;

use Incoded\Core\Form\Field\Field;

class Radio extends Field
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
        $attributes['id']     = isset($attributes['id']) ? $attributes['id'] : $namespace.'_'.$this->name;

        $options = $this->getCheckboxes($this->values, $this->value, $attributes);

        return implode("", $options)."";
    }

    protected function getCheckboxes($values, $selected_value = '', $attributes = array())
    {
        $selected = false;
        $format   = '%radio%%label%';
        $attributes['checked'] = 'checked';

        if (isset($this->options['format']) && $this->options['format'] !== false)
        {
            $format = $this->options['format'];
        }

        foreach ($values as $value => $label)
        {
            $attributes['value'] = $value;

            unset($attributes['checked']);
            if (!$selected && ($selected_value == '' || $value == $selected_value))
            {
                $attributes['checked'] = 'checked';
                $selected = true;
            }

            $attributes['id'] = $attributes['id'] . '_' . $value;

            $radio = sprintf('<input type="radio"%s />', implode('', array_map(array($this, 'attributesToHtmlCallback'), array_keys($attributes), array_values($attributes))));
            $label = sprintf('<label for="%s">%s</label>', $attributes['id'], $label);

            $options[] = str_replace(array('%radio%', '%label%'), array($radio, $label), $format);
        }

        return $options;
    }

    protected function attributesToHtmlCallback($k, $v)
    {
        return false === $v || null === $v || ('' === $v && 'value' != $k) ? '' : sprintf(' %s="%s"', $k, $v);
    }
}
?>
