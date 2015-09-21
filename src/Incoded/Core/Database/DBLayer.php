<?php
namespace Incoded\Core\Database;

class DBLayer
{
    private $config = array();
    private $pdo;
    private $query;
    private $table = null;
    private $result = null;
    private $is_insert = false;

    public function __construct()
    {
        // get database parameters
        $config = @include INCODED_APP . DS . 'config' . DS . 'database.php';

        if (!isset($config['default'])) {
            throw new \Exception('Database config does not exist.');
        }

        $this->config = $config['default'];

        // connect to database
        try {

            $this->pdo = new \PDO($this->config['dsn'], $this->config['username'], $this->config['password']);
            $this->pdo->exec('SET CHARACTER SET ' . $this->config['encoding']);

        } catch (\PDOException $e) {

            throw new \Exception(sprintf('ERROR %s: %s', $e->getCode(), $e->getMessage()));

        }
    }

    public function getConnection()
    {
        return $this->pdo;
    }

    public function select($columns = '*')
    {
        $this->query = sprintf("SELECT %s FROM %s;", $columns, "%s");

        return $this;
    }

    public function insert(array $columns)
    {
        foreach ($columns as $k => $v)
        {
            $columns[$k] = "'" . $v . "'";
        }

        $cols = implode(', ', array_keys($columns));
        $vals = implode(', ', array_values($columns));

        $this->query = sprintf("INSERT INTO %s (%s) VALUES (%s);", "%s", $cols, $vals);

        $this->is_insert = true;

        return $this;
    }

    public function update(array $columns, $condition = null)
    {
        $vals = '';
        foreach ($columns as $k => $v)
        {
            $vals[] = $k . " = '" . $v . "'";
        }
        $vals = implode(', ', array_values($vals));

        $query = sprintf("UPDATE %s SET %s;", "%s", $vals);
        if ($condition) {
            $query = sprintf("UPDATE %s SET %s WHERE %s;", "%s", $vals, $condition);
        }
        $this->query = $query;

        return $this;
    }

    public function delete($condition)
    {
        $this->query = sprintf("DELETE FROM %s WHERE %s;", "%s", $condition);

        return $this;
    }

    public function table($table)
    {
        $this->table = $table;
        $this->query = sprintf($this->query, $table);

        return $this;
    }

    public function where($condition)
    {
        $stmt = sprintf(' WHERE %s;', $condition);
        $this->query = str_replace(';', $stmt, $this->query);

        return $this;
    }

    public function order($column, $order = 'ASC')
    {
        $stmt = sprintf(' ORDER BY %s %s;', $column, $order);
        $this->query = str_replace(';', $stmt, $this->query);

        return $this;
    }

    public function limit($rows, $offset = 0)
    {
        $stmt = sprintf(' LIMIT %s, %s;', $offset, $rows);
        $this->query = str_replace(';', $stmt, $this->query);

        return $this;
    }

    public function execute()
    {
        if (!$this->table) return false;
        
        // execute query
        $this->result = $this->pdo->prepare($this->query);
        $this->result->execute();
    
        // return $this->postExecute();
    }

    private function postExecute()
    {
        if ($this->is_insert) {
            $this->is_insert = false;
            return $this->pdo->lastInsertId();
        }
    }

    public function fetch($style = \PDO::FETCH_ASSOC)
    {
        return $this->result->fetch($style);
    }

    public function fetchAll($style = \PDO::FETCH_ASSOC, $argument = \PDO::FETCH_COLUMN)
    {
        return $this->result->fetchAll($style);
    }

    public function getQuery()
    {
        return $this->query;
    }

    public function executeQuery($query)
    {
        try 
        {
            $this->pdo->exec($query);
        }
        catch (\PDOException $e)
        {
            throw new Exception(sprintf('%s ERROR %s: %s', get_class($this), $e->getCode(), $e->getMessage()));            
        }
    }
}