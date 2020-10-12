<?php

namespace app\models;

use app\services\DB;

abstract class Model
{
    abstract protected static function getTableName(): string;


    /*
     * @return DB
     */

    protected static function getDB()
    {
        return DB::getInstance();
    }

    public  static function getOne($id)
    {
        $tableName = static::getTableName();
        $sql = "SELECT * FROM {$tableName} WHERE id =  :id";
        $params = [':id' => $id];
        return static::getDB()->getObject($sql, static::class, $params);
    }

    public static function getAll()
    {
        $tableName = static::getTableName();
        $sql = "SELECT * FROM {$tableName}";
        return static::getDB()->getAllObjects($sql, static::class);
    }

    public function insert() //добавление в БД
    {
        $fields = [];
        $params = [];

        foreach ($this as $fieldName => $value) {
            if ($fieldName == 'id') {
                continue;
            }
            $fields[] = $fieldName;
            $params[":{$fieldName}"] = $value;
        }

        $sql = sprintf(
            "INSERT INTO %s (%s) VALUES (%s)",
            static::getTableName(),
            implode(',', $fields),
            implode(',', array_keys($params))
        );

        static::getDB()->execute($sql, $params);
        $this->id = static::getDB()->getLastId();
    }

    public function update($id) //обновление данных в БД
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
        foreach ($this as $fieldName => $value) {
            $params[":{$fieldName}"] = $value;
            if ($fieldName == "id") {
                continue;
            }
            $fields[] = "{$fieldName} = :{$fieldName}";
        }

        $sql = sprintf(
            "UPDATE %s SET %s WHERE id = :id",
            static::getTableName(),
            implode(',', $fields)
        );

        static::getDB()->execute($sql, $params);
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
