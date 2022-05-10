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
    private $status; // PRIVATE, PUBLIC, HIDDEN
 
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
     * @return Topic array that contains all the topics
     */
    public static function fetchAll()
    {
        $allTopics = Model::readAll("topic", "Topic");

        return $allTopics; // TODO : Upgrade
    }

    public static function fetchAllOrderBy($column)
    {
        // TODO
    }
    
    /**
     * fetchId
     *
     * @param  mixed $id The ID of the topic
     * @return Topic The topic that is matching the ID
     */
    public static function fetchId($id)
    {
        // ASSUMPTION
        //    - $id was validated by the caller

        return Model::readById("topic", "Topic", $id);
    }
    
    /**
     * save The topic in the database
     *
     * @return void
     */
    public function save()
    {
        $user_id = 1; // TO DO LATER

        $topic_values = [
            "name" => $this->name,
            "content" => $this->content,
            "rank" => $this->rank,
            "update_timestamp" => $this->update_timestamp,
            "creation_timestamp" => $this->creation_timestamp,
            "fk_user" => $user_id,
            "status" => $this->status,
        ];

        Model::create("topic", $topic_values);
    }
    
    /**
     * getAsBootstrapGridForHomePage
     *
     * @return string That contains the HTML code for displaying the topic in the homepage
     */
    public function getAsBootstrapGridForHomePage()
    {
        $install_prefix = App::get('config')['install_prefix'];

        $pathToTheTopic = "/" . $install_prefix . "/topic_show?id=" . htmlentities($this->id);

        $topicHtml = 
            "<div class='col-sm m-1 card mt-3'>
                <div class='card-header'>
                Author : "
                .
                    htmlentities($this->whoWroteTopic()) . " (" . htmlentities($this->status) . ")"
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
    
    /**
     * getAsBootstrapGridForTopicPage
     *
     * @return string That contains the HTML code for displaying the topic in the topicpage
     */
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
                    "</p>";
        if(isset($_SESSION[User::$UserAccessLevel]) && $_SESSION[User::$UserAccessLevel] == "logged")
        {
        $topicHtml .= "
                    <div class='d-grid gap-2 d-md-flex justify-content-md-end'>
                        <a href='/". $editPath ."' class='btn btn-secondary'><i class=\"fa-solid fa-pen\"></i></a>
                        <a href='/". $deletePath ."' class='btn btn-danger'><i class=\"fa-solid fa-trash-can\"></i></a>
                    </div>";
        }
        $topicHtml .= "
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
    
    /**
     * getTitleForTopicPage
     *
     * @return string
     */
    public function getTitleForTopicPage()
    {
        return htmlentities($this->name) . ", created by " . htmlentities($this->whoWroteTopic());
    }
    
    /**
     * modify the topic in the database
     *
     * @return void
     */
    public function modify()
    {
        $params = [
            'name' => $this->name,
            'content' => $this->content,
            'creation_timestamp' => $this->creation_timestamp,
            'update_timestamp' => date("Y-m-d H:i:s"),
            'status' => $this->status
        ];

        Model::update("topic", $this->id, $params);

        $install_prefix = App::get('config')['install_prefix'];
        Helper::redirect($install_prefix . "/topic_show?id=" . $this->id);
    }
    
    /**
     * remove the topic from the database
     *
     * @return void
     */
    public function remove()
    {
        Model::delete('topic', $this->id);
    }
    
    /**
     * whoWroteTopic
     *
     * @return string the author of the topic
     */
    private function whoWroteTopic()
    {
        $user = User::fetchId($this->fk_user);
        return $user->username;
    }
}