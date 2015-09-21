<?php
namespace Incoded\Core\Form;

use Incoded\Core\Form\Field\InputHidden;

abstract class Form implements \ArrayAccess
{
    private
        $values    = array(),
        $fields    = array(),
        $errors    = array(),
        $namespace = '';

    protected
        $csrf_token_value;

    public function __construct($values = array(), $fields = array(), $namespace = '')
    {
        $this->values    = $values;
        $this->fields    = $fields;
        $this->namespace = $namespace == '' ? '' : $namespace . '_';

        $this->setFields($fields);
        $this->setValues($values);

        $this->init();
    }

    abstract public function init();

    public function setFields(Array $fields = array())
    {
        $this->fields = array_merge($fields, array(
            'csrf_token' => new InputHidden('csrf_token', $this->getCSRFTokenValue())
        ));

        $this->setValuesIntoFields();
    }

    private function setValuesIntoFields()
    {
        foreach ($this->fields as $fname => $field) {
            if (isset($this->values[$fname])) {
                $field->setValue($this->values[$fname]);
            }
        }
    }

    public function setValues(Array $values = array())
    {
        $this->values = $values;
    }

    public function getValues()
    {
        return $this->values;
    }

    public function showHidden()
    {
        foreach ($this->fields as $name => $field)
        {
            if ($field instanceof InputHidden) echo $field;
        }
    }

    public function isValid()
    {
        $values = $this->getValues();

        if (isset($values['csrf_token']) && $values['csrf_token'] == $this->getCSRFTokenValue()) {
            return true;
        }

        $this->setError('csrf_token', 'Cross-site request forgery.');

        return false;
    }

    public function hasErrors()
    {
        if (count($this->getErrors())) {
            return true;
        }

        return false;
    }

    public function getErrors()
    {
        return $this->errors;
    }

    public function getError($name)
    {
        return isset($this->errors[$name]) ? $this->errors[$name] : '';
    }

    public function hasError($name)
    {
        return isset($this->errors[$name]) ? true : false;
    }

    public function setError($name, $message)
    {
        $this->errors[$name] = $message;
    }

    public function getCSRFTokenValue()
    {
        // $this->csrf_token_value = md5(uniqid(mt_rand(), true));
        // $this->csrf_token_value = md5($secret.session_id().get_class($this));
        $this->csrf_token_value = md5(session_id().get_class($this));

        return $this->csrf_token_value;
    }

    public function offsetSet($offset, $value)
    {
        if (is_null($offset)) {
            $this->fields[] = $value;
        } else {
            $this->fields[$offset] = $value;
        }
    }

    public function offsetExists($offset)
    {
        return isset($this->fields[$offset]);
    }

    public function offsetUnset($offset)
    {
        unset($this->fields[$offset]);
    }

    public function offsetGet($offset)
    {
        return isset($this->fields[$offset]) ? $this->fields[$offset] : null;
    }
}
?>
