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
        $keys = implode(", ", array_keys($params)); // $keys = implode(", ", array_map(function ($key) { return "`{$key}`";}, array_keys($params)));

        $req = "INSERT INTO `{$table}` ({$keys}) VALUES ({$binding});";
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

        $statement = $dbh->prepare("SELECT * FROM `{$table}`;");
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

        $statement = $dbh->prepare("SELECT * FROM `{$table}` ORDER BY {$orderBy};");
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
    protected static function readAllByIdOrderBy($table, $className, $id, $orderBy)
    {
        $dbh = App::get('dbh');

        $statement = $dbh->prepare("SELECT * FROM `{$table}` WHERE id=:model_id ORDER BY {$orderBy};");
        $statement->bindParam(':model_id', $id);
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

        $statement = $dbh->prepare("SELECT * FROM `{$table}` WHERE id=:model_id;");
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
     * @return Array
     */
    protected static function readByCriteria($table, $className, $criteria, $criteriaValue)
    {
        $dbh = App::get('dbh');

        $statement = $dbh->prepare("SELECT * FROM `{$table}` WHERE {$criteria}=:criteria_value;");
        $statement->bindParam(':criteria_value', $criteriaValue);
        $statement->setFetchMode(PDO::FETCH_CLASS, $className);
        $statement->execute();

        return $statement->fetchAll();
    }

    /**
     * SELECT
     *
     * @param  mixed $table Table name
     * @param  mixed $className Class name
     * @param  mixed $criterias Associative array containing criterias names and criterias values
     * @return Array
     */
    protected static function readByCriterias($table, $className, $criterias)
    {
        $dbh = App::get('dbh');

        $keys = array_keys($criterias);
        $tab_set = array_map(function ($k) { return "{$k}=:{$k}"; }, $keys);

        $set_string = implode(" AND ", $tab_set);

        $req = "SELECT * FROM `{$table}` WHERE {$set_string}";
        $statement = $dbh->prepare($req);

        array_map(function ($key, $value) use($statement) { $statement->bindParam(":{$key}", $value); }, array_keys($criterias), array_values($criterias));

        $statement->setFetchMode(PDO::FETCH_CLASS, $className);

        $statement->execute();

        return $statement->fetchAll();
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

        $criteria = [
            "id" => $id
        ];
        
        Model::updateByCriterias($table, $criteria, $params);
    }

    /**
     * UPDATE
     * @param String $table Table name
     * @param String $id Id
     * @param Array $params The parameters to update
     */
    protected static function updateByCriterias($table, $criterias, $params)
    {
        $dbh = App::get('dbh');

        $params_keys = array_keys($params);
        $params_tab_set = array_map(function ($k) { return "`{$k}`=:{$k}"; }, $params_keys);
        $params_set_string = implode(", ", $params_tab_set);

        $criteria_keys = array_keys($criterias);
        $criteria_tab_set = array_map(function ($k) { return "{$k}=:{$k}"; }, $criteria_keys);
        $criteria_set_string = implode(" AND ", $criteria_tab_set);

        $req = "UPDATE `{$table}` SET {$params_set_string} WHERE {$criteria_set_string};";
        $statement = $dbh->prepare($req);

        $params = array_merge($params, $criterias);

        array_map(function ($key, $value) use($statement) { $statement->bindParam(":{$key}", $value); }, array_keys($params), array_values($params));

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

    /**
     * DELETE FROM
     * @param String $table Table name
     * @param Array $criterias The criterias
     */
    protected static function deleteByCriteria($table, $criterias)
    {
        $dbh = App::get('dbh');

        $criteria_keys = array_keys($criterias);
        $criteria_tab_set = array_map(function ($k) { return "{$k}=:{$k}"; }, $criteria_keys);
        $criteria_set_string = implode(" AND ", $criteria_tab_set);

        $req = "DELETE FROM `{$table}` WHERE  {$criteria_set_string};";

        $statement = $dbh->prepare($req);

        array_map(function ($key, $value) use($statement) { $statement->bindParam(":{$key}", $value); }, array_keys($criterias), array_values($criterias));

        $statement->execute();
    }
}