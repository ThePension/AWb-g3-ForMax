<?php

/**
 * Abstract class forcing extending class (AppQueryBuilder) to inherit this class
 */
abstract class Model
{
    protected static function fetchAll($table, $intoClass)
    {
        $statement = App::get('dbh')->prepare("select * from {$table}");
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_CLASS, $intoClass);
    }

    protected static function fetchById($id, $table, $intoClass)
    {
        // ASSUMPTION
        //    - $id was validated by the caller

        $statement = App::get('dbh')->prepare("select * from {$table} where id=:row_id");
        $statement->bindParam(':row_id', $id);
        $statement->setFetchMode(PDO::FETCH_CLASS, $intoClass);
        $statement->execute();
        return $statement->fetch();
    }

    // abstract non static implementation
    abstract protected function save();

}
