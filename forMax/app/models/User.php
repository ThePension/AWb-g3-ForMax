<?php

class User extends Model
{
    private $id;
    private $username;
    private $password;
    private $description;
    private $timestamp;
    
    static public $UserSessionId = "user_id";
    static public $UserAccessLevel = "user_access_level";

    /**
     * __set
     *
     * @param  mixed $property Is the property name
     * @param  mixed $value is the value to be set
     * @return void
     */
    public function __set($property, $value)
    {
        $this->$property= $value;
    }

    /**
     * __get
     *
     * @param  mixed $property The property name
     * @return mixed The property value
     */
    public function __get($property)
    {
        return $this->$property;
    }
    
    /**
     * fetchAll
     *
     * @return User array that contains all the users
     */
    public static function fetchAll()
    {
        $allUsers = Model::readAll("user", "User");

        return $allUsers; // TODO : Upgrade
    }

    public static function fetchAllOrderBy($column)
    {
        // TODO : Adapt for our case
    }

    /**
     * fetchId
     *
     * @param  mixed $id The ID of the user
     * @return User that is matching the ID
     */
    public static function fetchId($id)
    {
        // ASSUMPTION
        //    - $id was validated by the caller

        return Model::readById("user", "User", $id);
    }

    /**
     * fetchUsername
     *
     * @param  mixed $username The username of the user
     * @return User that is matching the username
     */
    public static function fetchUsername($username)
    {
        return Model::readByCriteria("user", "User", "username", $username);
    }

    /**
     * save The user in the database
     *
     * @return void
     */
    public function save()
    {
        $user_values = [
            "username" => $this->username,
            "password" => $this->password,
            "description" => $this->description,
            "timestamp" => $this->timestamp
        ];

        Model::create("user", $user_values);
    } 
}