<?php
namespace Incoded\Core\Database;

use Incoded\Core\Database\DBLayer;

abstract class Model
{
    private $db;

    private $table;

    private $pk = null;

    private $is_new = true;

    private $columns = array();

    private $values = array();

    public function __construct($pk = null)
    {
        $this->db = new DBLayer();

        $this->init();

        if ($pk) {
            $this->loadModel($pk);
        }
    }

    abstract public function init();

    public function save()
    {
        $values = $this->getValues();

        if ( isset($values[$this->getPk()]) ) {
            unset($values[$this->getPk()]);
        }

        if ($this->getIsNew()) {
            $this->db->insert($values);
        } else {
            $this->db->update($values, 'id=1');
        }

        $this->db->table($this->getTable())->execute();
    }

    public function loadModel($pk)
    {
        $this->db->select()
            ->table($this->getTable())
            ->where($this->getPk() . '=' . $pk)
            ->execute();

        $this->setValues($this->db->fetch());

        $this->setIsNew(false);
    }

    public function setTable($table)
    {
        $this->table = $table;
    }

    public function getTable()
    {
        return $this->table;
    }

    public function setPk($pk)
    {
        $this->pk = $pk;
    }

    public function getPk()
    {
        return $this->pk;
    }

    public function setIsNew($is_new)
    {
        $this->is_new = $is_new;
    }

    public function getIsNew()
    {
        return $this->is_new;
    }

    public function setColumns(Array $columns = array())
    {
        $this->columns = $columns;
    }

    public function getColumns()
    {
        return $this->columns;
    }

    public function setValues(Array $values = array())
    {
        $this->values = $values;
    }

    public function getValues()
    {
        return $this->values;
    }
}