<?php

class Topic extends Model
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

    public static function fetchAll()
    {
        $allTopics = Model::readAll("topic", "Topic");

        return $allTopics; // TODO : Upgrade
    }

    public static function fetchAllOrderBy($column)
    {
        // TODO : Adapt for our case

        // old version
        /*
        $allTasks = Model::readAllOrderBy("task", "Task", $column);

        return array_filter($allTasks, function ($v)
        {
            $user_id = $_SESSION[Login::$UserSessionId];
            return $v->fk_user == $user_id;
        });
        */
    }

    public static function fetchId($id)
    {
        // ASSUMPTION
        //    - $id was validated by the caller

        return Model::readById("topic", "Topic", $id);
    }

    public function save()
    {
        // TODO : Adapt for our version

        // old version
        /*
        $user_id = $_SESSION[Login::$UserSessionId];
        $task_values = [
            "description" => $this->description,
            "completed" => $this->completed,
            "deadline" => $this->deadline,
            "fk_user" => $user_id
        ];

        Model::create("task", $task_values);
        */
    }

    public function getAsBootstrapGridForHomePage()
    {
        $install_prefix = App::get('config')['install_prefix'];

        $pathToTheTopic = "/" . $install_prefix . "/topic_show?id=" . htmlentities($this->id);

        $topicHtml = 
            "<div class='card'>
                <div class='card-header'>"
                .
                    htmlentities($this->name)
                .
                "</div>
                <div class='card-body'>
                    <p class='card-text text-truncate'>"
                    .
                        htmlentities($this->content)
                    .
                    "</p>
                    <a href='". $pathToTheTopic ."' class='btn btn-info'>Read further</a>
                    <p>created on "
                    .
                        htmlentities($this->creation_timestamp)
                    .
                    " | updated on "
                    .
                        htmlentities($this->update_timestamp)
                    .
                    "</p>
                </div>
            </div>";

        return $topicHtml;
    }

    public function getAsBootstrapGridForTopicPage()
    {

    }
}