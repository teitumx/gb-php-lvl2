<?php

namespace app\services;

use app\traits\SingletonTrait;

class DB
{

    private $config;
    private $connection;

    public function __construct($config)
    {
        $this->config = $config;
    }

    private  function  getConnection() //подключение к базе данных
    {
        if (empty($this->connection)) {
            $this->connection = new \PDO(
                $this->getSDN(),
                $this->config['login'],
                $this->config['password']
            );

            $this->connection->setAttribute(
                \PDO::ATTR_DEFAULT_FETCH_MODE,
                \PDO::FETCH_ASSOC
            ); //преобразовываем полученные данные в массив
        }

        return $this->connection;
    }

    public function getSDN()
    {
        return sprintf(
            '%s:host=%s;dbname=%s;charset=%s',
            $this->config['driver'],
            $this->config['host'],
            $this->config['dbname'],
            $this->config['charset']
        );
    }

    private function query($sql, $params = [])
    {
        $PDOStatement = $this->getConnection()->prepare($sql); //делаем запрос
        $PDOStatement->execute($params); //передаём параметры
        return $PDOStatement;
    }

    public function find($sql, $params)
    {

        return $this->query($sql, $params)->fetch(); // получаем необходимую строку из БД
    }

    public function findAll($sql, $params = [])
    {
        return $this->query($sql, $params)->fetchAll();
    }

    public function  getObject($sql, $className, $params = [])
    {
        $PDOStatement = $this->query($sql, $params);
        $PDOStatement->setFetchMode(\PDO::FETCH_CLASS, $className);
        return $PDOStatement->fetch();
    }

    public function getAllObjects($sql, $className, $params = [])
    {
        $PDOStatement = $this->query($sql, $params);
        $PDOStatement->setFetchMode(\PDO::FETCH_CLASS, $className);
        return $PDOStatement->fetchAll();
    }

    public function execute($sql, $params = [])
    {
        $this->query($sql, $params);
    }

    public function getLastId() //получение последнего id
    {
        return $this->getConnection()->lastInsertId();
    }
}
