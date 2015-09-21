<?php
namespace Incoded\Core\Database;

use Incoded\Core\Database\DBLayer;

abstract class Collection
{
    private $db;

    private $models = array();

    private $model;

    private $model_name;

    private $model_pk;

    public function __construct($condition = false)
    {
        $this->db = new DBLayer();

        $this->init();

        $model = $this->getModel();

        $this->setModel($model);
        $this->setModelName(get_class($model));
        $this->setModelPk($model->getPk());

        $this->loadModels($condition);
    }

    public function loadModels($condition = false)
    {
        $models = array();

        $this->db->select()
            ->table($this->getModel()->getTable());

        if ($condition) {
            $this->db->where($condition);
        }

        $this->db->execute();

        foreach ($this->db->fetchAll() as $record)
        {
            $model      = $this->getModel();
            $model_name = $this->getModelName();
            $model_pk   = $this->getModelPk();

            $model = new $model_name($model_pk);
            $model->setValues($record);

            $this->addModel($model);
        }
    }

    public function setModels(Array $models = array())
    {
        $this->models = $models;
    }

    public function getModels()
    {
        return $this->models;
    }

    public function setModel($model)
    {
        $this->model = $model;
    }

    public function getModel()
    {
        return $this->model;
    }

    public function setModelName($name)
    {
        $this->name = $name;
    }

    public function getModelName()
    {
        return $this->name;
    }

    public function setModelPk($pk)
    {
        $this->model_pk = $pk;
    }

    public function getModelPk()
    {
        return $this->model_pk;
    }

    public function addModel($model)
    {
        $this->models[] = $model;
    }
}