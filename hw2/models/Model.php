<?php
// namespace models\Model;

abstract class Model
{
    protected $db;
    protected $tableName;

    abstract protected function getTableName(): string;

    public function __construct(IDB $db)
    {
        $this->db = $db;
    }

    public function getOne($id)
    {
        $tableName = $this->getTableName();
        $sql = "SELECT * FROM {$tableName} WHERE id = " . $id;
        return (new DB())->find($sql);
    }

    public function getAll()
    {
        $tableName = $this->getTableName();
        $sql = "SELECT * FROM {$tableName}";
        return (new DB())->findAll($sql);
    }
}
