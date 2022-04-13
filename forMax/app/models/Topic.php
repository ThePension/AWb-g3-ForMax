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
            "<div class='col-sm m-1 card mt-3'>
                <div class='card-header'>
                created by "
                .
                    htmlentities($this->howWroteTopic())
                .
                "</div>
                <div class='card-body'>
                    <h5 class='card-title'>".
                        htmlentities($this->name)
                    ."</h5>
                    <p class='card-text text-truncate-container'>"
                    .
                        htmlentities($this->content)
                    .
                    "</p>
                    <a href='". $pathToTheTopic ."' class='btn btn-info text-light'>Read further</a>
                </div>
                <div class='card-footer text-muted container'>
                    <div class='row'>
                        <p class='col text-start'>
                            created on "
                            .
                                htmlentities($this->creation_timestamp)
                            .   
                        "</p>
                        <p class='col text-end'>
                            updated on "
                            .
                                htmlentities($this->update_timestamp)
                            .   
                        "</p>
                    </div>
                </div>
            </div>";

        return $topicHtml;
    }

    public function getAsBootstrapGridForTopicPage()
    {
        $topicHtml = 
            "<div class='col-sm m-1 card mt-3'>
                <div class='card-header'>
                created by "
                .
                    htmlentities($this->howWroteTopic())
                .
                "</div>
                <div class='card-body'>
                    <h5 class='card-title'>".
                        htmlentities($this->name)
                    ."</h5>
                    <p class='card-text'>"
                    .
                        htmlentities($this->content)
                    .
                    "</p>
                </div>
                <div class='card-footer text-muted container'>
                    <div class='row'>
                        <p class='col text-start'>
                            created on "
                            .
                                htmlentities($this->creation_timestamp)
                            .   
                        "</p>
                        <p class='col text-end'>
                            updated on "
                            .
                                htmlentities($this->update_timestamp)
                            .   
                        "</p>
                    </div>
                </div>
            </div>";

        return $topicHtml;
    }

    private function howWroteTopic()
    {
        $user = User::fetchId($this->fk_user);
        return $user->username;
    }
}