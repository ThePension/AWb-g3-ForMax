<?php

class Comment
{
    private $id;
    private $title;
    private $likes;
    private $content;
    private $timestamp;
    private $fk_user;
    private $fk_topic;

    public function __set($property, $value)
    {
        $this->property= $value;
    }

    public function __get($property)
    {
        return $this->property;
    }
}