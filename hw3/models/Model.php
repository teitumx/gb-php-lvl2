<?php

namespace app\models;

use app\services\DB;

abstract class Model
{
    abstract protected function getTableName(): string;


    /*
     * @return DB
     */

    protected function getDB()
    {
        return DB::getInstance();
    }

    public function getOne($id)
    {
        $tableName = $this->getTableName();
        $sql = "SELECT * FROM {$tableName} WHERE id =  :id";
        $params = [':id' => $id];
        return $this->getDB()->find($sql, $params);
    }

    public function getAll()
    {
        $tableName = $this->getTableName();
        $sql = "SELECT * FROM {$tableName}";
        return $this->getDB()->findAll($sql);
    }

    public function insert() //добавление в БД
    {
        $tableName = $this->getTableName();
        $col = [];
        $val = [];
        $params = [];
        foreach ($this as $fieldName => $value) {
            $col[] = $fieldName;
            $val[] = ":$fieldName";
            $params[":$fieldName"] = $value;
        }
        $col = implode(',', $col);
        $val = implode(',', $val);
        $sql = "INSERT INTO $tableName ($col) VALUES ($val)";

        $this->getDB()->execute($sql, $params);
    }

    public function update($id) //обновление данных в БД
    {
        $tableName = $this->getTableName();
        $col = [];
        $val = [];
        $params = [];
        foreach ($this as $fieldName => $value) {
            $col[] = $fieldName;
            $val[] = ":$fieldName";
            $params[":$fieldName"] = $value;
        }
        $col = implode(',', $col);
        $val = implode(',', $val);
        $sql = "UPDATE $tableName SET ($col) = ($val) WHERE $tableName.id = $id;";
        return $this->getDB()->execute($sql, $params);
    }

    public function save()
    {
        if (empty($this->id)) {
            return $this->insert();
        }

        return $this->update($this->id);
    }

    public function delete($id) //удаление из БД
    {
        $tableName = $this->getTableName();
        $sql = "DELETE FROM $tableName  WHERE $tableName .id = :id";
        $params = [':id' => $id];
        return $this->getDB()->execute($sql, $params);
    }
}
