<?php

class IndexController
{
    public function index()
    {
        return Helper::view("index");
    }

    public function about()
    {
        return Helper::view("about");
    }
}