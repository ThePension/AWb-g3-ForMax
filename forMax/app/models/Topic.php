<?php

class Topic
{
    private $id;
    private $name;
    private $content;
    private $rank;
    private $update_timestamp;
    private $creation_timestamp;
    private $fk_user;

    public function __set($property, $value)
    {
        $this->property= $value;
    }

    public function __get($property)
    {
        return $this->property;
    }
}