<?php

class IndexController
{    
    /**
     * index
     *
     * @return view Index
     */
    public function index()
    {
        return Helper::view("index");
    }
    
    /**
     * about
     *
     * @return view About
     */
    public function about()
    {
        return Helper::view("about");
    }
}