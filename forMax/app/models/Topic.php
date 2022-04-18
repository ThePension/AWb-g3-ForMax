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
        $this->$property= $value;
    }

    public function __get($property)
    {
        return $this->$property;
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
        $user_id = 1; // TO DO LATER

        $topic_values = [
            "name" => $this->name,
            "content" => $this->content,
            "rank" => $this->rank,
            "update_timestamp" => $this->update_timestamp,
            "creation_timestamp" => $this->creation_timestamp,
            "fk_user" => $user_id
        ];

        Model::create("topic", $topic_values);
    }

    public function getAsBootstrapGridForHomePage()
    {
        $install_prefix = App::get('config')['install_prefix'];

        $pathToTheTopic = "/" . $install_prefix . "/topic_show?id=" . htmlentities($this->id);

        $topicHtml = 
            "<div class='col-sm m-1 card mt-3'>
                <div class='card-header'>
                Author : "
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
        $install_prefix = App::get('config')['install_prefix'];

        $deletePath = $install_prefix . "/topic_delete?id=" . htmlentities($this->id);
        $editPath = $install_prefix . "/topic_update?id=" . htmlentities($this->id);

        $topicHtml = 
            "<div class='col-sm m-1 card mt-3'>
                <div class='card-body'>
                    <p class='card-text'>"
                    .
                        htmlentities($this->content)
                    .
                    "</p>
                    <div class='d-grid gap-2 d-md-flex justify-content-md-end'>
                        <a href='/". $editPath ."' class='btn btn-secondary'>Edit</a>
                        <a href='/". $deletePath ."' class='btn btn-danger'>Delete</a>
                    </div>
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

    public function getTitleForTopicPage()
    {
        return htmlentities($this->name) . ", created by " . htmlentities($this->howWroteTopic());
    }

    public function remove()
    {
        Model::delete('topic', $this->id);
    }

    private function howWroteTopic()
    {
        $user = User::fetchId($this->fk_user);
        return $user->username;
    }
}