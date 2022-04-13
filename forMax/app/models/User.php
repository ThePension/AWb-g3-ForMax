<?php

class User extends Model
{
    private $id;
    private $username;
    private $password;
    private $description;
    private $timestamp;

    public function __set($property, $value)
    {
        $this->$property= $value;
    }

    public function __get($property)
    {
        return $this->$property;
    }

    public static function fetchAll()
    {
        $allUsers = Model::readAll("user", "User");

        return $allUsers; // TODO : Upgrade
    }

    public static function fetchAllOrderBy($column)
    {
        // TODO : Adapt for our case
    }

    public static function fetchId($id)
    {
        // ASSUMPTION
        //    - $id was validated by the caller

        return Model::readById("user", "User", $id);
    }
}