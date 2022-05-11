<?php

/**
 * Abstract class forcing extending class (AppQueryBuilder) to inherit this class
 */
abstract class Model
{
    /**
     * INSERT INTO
     * @param String $table Table name
     * @param Array $params Arrays of parameters
     */
    protected static function create($table, $params)
    {
        $dbh = App::get('dbh');

        $copyParam = array_map(function ($x) { return "?"; }, $params);

        $binding = implode(", ", $copyParam);
        $keys = implode(", ", array_keys($params));

        $req = "INSERT INTO {$table} ({$keys}) VALUES ({$binding});";
        $statement = $dbh->prepare($req);

        $statement->execute(array_values($params));
    }

    /**
     * SELECT * FROM
     * @param String $table Table name
     * @param String $className The class name
     * @return Array The model
     */
    protected static function readAll($table, $className)
    {
        $dbh = App::get('dbh');

        $statement = $dbh->prepare("SELECT * FROM {$table};");
        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_CLASS, $className);
    }

    /**
     * SELECT * FROM ORDER BY
     * @param String $table Table name
     * @param String $className The class name
     * @param String $orderBy The column name
     * @return Array The model
     */
    protected static function readAllOrderBy($table, $className, $orderBy)
    {
        $dbh = App::get('dbh');

        $statement = $dbh->prepare("SELECT * FROM {$table} ORDER BY {$orderBy};");
        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_CLASS, $className);
    }

    /**
     * SELECT * FROM $table WHERE Id
     * @param String $table Table name
     * @param String $className The class name
     * @param String $id The id
     */
    protected static function readById($table, $className, $id)
    {
        $dbh = App::get('dbh');

        $statement = $dbh->prepare("SELECT * FROM {$table} WHERE id=:model_id;");
        $statement->bindParam(':model_id', $id);
        $statement->setFetchMode(PDO::FETCH_CLASS, $className);
        $statement->execute();

        return $statement->fetch();
    }
    
    /**
     * SELECT * FROM $table WHERE $criteria=$criteriaValue
     *
     * @param  mixed $table Table name
     * @param  mixed $className Class name
     * @param  mixed $criteria Criteria name
     * @param  mixed $criteraValue Criteria value
     * @return User
     */
    protected static function readByCriteria($table, $className, $criteria, $criteriaValue)
    {
        $dbh = App::get('dbh');

        $statement = $dbh->prepare("SELECT * FROM {$table} WHERE {$criteria}=:criteria_value;");
        $statement->bindParam(':criteria_value', $criteriaValue);
        $statement->setFetchMode(PDO::FETCH_CLASS, $className);
        $statement->execute();

        return $statement->fetch();
    }

    /**
     * UPDATE
     * @param String $table Table name
     * @param String $id Id
     * @param Array $params The parameters to update
     */
    protected static function update($table, $id, $params)
    {
        $dbh = App::get('dbh');

        $callback = function(string $k): string
        {
            return "{$k}=:{$k}";
        };

        $keys = array_keys($params);
        $values = array_values($params);
        $tab_set = array_map($callback, $keys);

        $set_string = implode(", ", $tab_set);

        $req = "UPDATE {$table} SET {$set_string} WHERE id=:model_id;";
        $statement = $dbh->prepare($req);
        
        for ($n = 0; $n < count($values); $n++)
        {
            $statement->bindParam(":{$keys[$n]}", $values[$n]);
        }
        $statement->bindParam(':model_id', $id);

        $statement->execute();
    }

    /**
     * DELETE FROM
     * @param String $table Table name
     * @param String $id Id
     */
    protected static function delete($table, $id)
    {
        $dbh = App::get('dbh');

        $req = "DELETE FROM {$table} WHERE id=:model_id;";

        $statement = $dbh->prepare($req);
        $statement->bindParam(':model_id', $id);

        $statement->execute();

    }
}