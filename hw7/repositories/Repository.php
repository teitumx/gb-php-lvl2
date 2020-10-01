<?php

namespace app\repositories;

use app\entities\Entity;
use app\services\DB;
use app\main\Container;

abstract class Repository
{
    protected $container;
    abstract protected function getTableName(): string;
    abstract protected function getEntityName(): string;

    public function setContainer(Container $container)
    {
        $this->container = $container;
    }

    /*
     * @return DB
     */

    protected function getDB()
    {
        return $this->container->db;
    }

    public function getOne($id)
    {
        $tableName = $this->getTableName();
        $sql = "SELECT * FROM {$tableName} WHERE id =  :id";
        $params = [':id' => $id];
        return $this->getDB()->getObject($sql, $this->getEntityName(), $params);
    }

    public function getAll()
    {
        $tableName = $this->getTableName();
        $sql = "SELECT * FROM {$tableName}";
        return $this->getDB()->getAllObjects($sql, $this->getEntityName());
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

        $this->getDB()->execute($sql, $params);
        $entity->id = $this->getDB()->getLastId();
        return $entity;
    }

    public function update(Entity $entity) //обновление данных в БД
    {
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

        $this->getDB()->execute($sql, $params);
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

    public static function userLoginAction($data)
    {

        $sql = "select password, id FROM users WHERE email= :email";
        $params = [":email" => $data['email']];
        // return $this->getDB()->execute($sql, $params);


        // if ($user['password'] === $data['password']) {
        //     if (!isset($_SESSION)) {
        //         session_start();
        //     }
        //     $_SESSION["user"] = $data['email'];
        //     $_SESSION["id"] = $user['id'];
        //     return TRUE;
        // } else {
        //     return FALSE;
        // }
    }
}
