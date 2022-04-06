<?php

class User
{
    private $id;
    private $username;
    private $password;
    private $description;
    private $timestamp;

    public function __set($property, $value)
    {
        $this->property= $value;
    }

    public function __get($property)
    {
        return $this->property;
    }
}