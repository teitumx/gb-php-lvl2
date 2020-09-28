<?php

namespace app\repositories;

use app\entities\Entity;
use app\services\DB;

abstract class Repository
{
    abstract protected function getTableName(): string;
    abstract protected function getEntityName(): string;


    /*
     * @return DB
     */

    protected static function getDB()
    {
        return DB::getInstance();
    }

    public function getOne($id)
    {
        $tableName = $this->getTableName();
        $sql = "SELECT * FROM {$tableName} WHERE id =  :id";
        $params = [':id' => $id];
        return static::getDB()->getObject($sql, $this->getEntityName(), $params);
    }

    public function getAll()
    {
        $tableName = $this->getTableName();
        $sql = "SELECT * FROM {$tableName}";
        return static::getDB()->getAllObjects($sql, $this->getEntityName());
    }

    public function insert(Entity $entity) //добавление в БД
    {
        $fields = [];
        $params = [];

        foreach ($entity as $fieldName => $value) {
            if ($fieldName == 'id') {
                continue;
            }
            $fields[] = $fieldName;
            $params[":{$fieldName}"] = $value;
        }

        $sql = sprintf(
            "INSERT INTO %s (%s) VALUES (%s)",
            $this->getTableName(),
            implode(',', $fields),
            implode(',', array_keys($params))
        );

        static::getDB()->execute($sql, $params);
        $entity->id = static::getDB()->getLastId();
        return $entity;
    }

    public function update(Entity $entity) //обновление данных в БД
    {
        // $tableName = static::getTableName();
        // $col = [];
        // $val = [];
        // $params = [];
        // foreach ($this as $fieldName => $value) {
        //     $col[] = $fieldName;
        //     $val[] = ":$fieldName";
        //     $params[":$fieldName"] = $value;
        // }
        // $col = implode(',', $col);
        // $val = implode(',', $val);
        // $sql = "UPDATE $tableName SET ($col) = ($val) WHERE $tableName.id = $id;";
        // return static::getDB()->execute($sql, $params);

        $fields = [];
        $params = [];
        foreach ($entity as $fieldName => $value) {
            $params[":{$fieldName}"] = $value;
            if ($fieldName == "id") {
                continue;
            }
            $fields[] = "{$fieldName} = :{$fieldName}";
        }

        $sql = sprintf(
            "UPDATE %s SET %s WHERE id = :id",
            $this->getTableName(),
            implode(',', $fields)
        );

        static::getDB()->execute($sql, $params);
        return $entity;
    }

    public function save(Entity $entity)
    {
        if (empty($entity->id)) {
            return $this->insert($entity);
        }

        return $this->update($entity);
    }

    public function delete($entity) //удаление из БД
    {
        $tableName = $this->getTableName();
        $sql = "DELETE FROM $tableName  WHERE $tableName .id = :id";
        $params = [':id' => $entity];
        return $this->getDB()->execute($sql, $params);
    }
}
