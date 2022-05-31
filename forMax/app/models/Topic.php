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
    private $private_key;
    private $comments_on; // 1 = True, 0 = False
 
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
     * @return Array of topics
     */
    public static function fetchAll()
    {
        $allTopics = Model::readAll("topic", "Topic");

        return $allTopics; // TODO : Upgrade
    }

    public static function fetchAllOrderBy($column)
    {
        return Model::readAllOrderBy("topic", "Topic", $column);
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
        $topic_values = [
            "name" => $this->name,
            "content" => $this->content,
            "rank" => $this->rank,
            "update_timestamp" => $this->update_timestamp,
            "creation_timestamp" => $this->creation_timestamp,
            "fk_user" => $this->fk_user,
            "status" => $this->status,
            "private_key" => $this->private_key,
            "comments_on" => $this->comments_on
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
        $pathToTheTopic = "/" . Helper::createUrl("topic_show") . "?id=" . htmlentities($this->id);

        $topicHtml = 
            '<div class="col card mt-2">
                <div class="card-header">
                Author : '
                .
                    htmlentities($this->whoWroteTopic())
                .
                '</div>
                <div class="card-body">
                    <h5 class="card-title">'.
                        htmlentities($this->name)
                    .'</h5>
                    <p class="card-text text-truncate-container">'
                    .
                        htmlentities($this->content)
                    .
                    '</p>
                    <div class="d-grid gap-2 d-md-flex">
                        <a href="'. $pathToTheTopic .'" class="btn btn-info text-light me-auto">Read further</a>
                        <h3 class="align-middle" id="like_counter_'.$this->id.'">'
                            . 
                            htmlentities($this->rank)
                            .
                        '</h3>';
                    if(isset($_SESSION[User::$UserSessionId]))
                    {
                        $like = TopicLike::fetchByUserIdAndTopicId($_SESSION[User::$UserSessionId], $this->id)[0];
                        $topicHtml .= 
                        '<a id="btn_like_'. $this->id . $_SESSION[User::$UserSessionId] .'" class="btn ' . ($like->value == 1 ? 'btn-danger' : 'btn-secondary') . '" onclick="addOrUpdateLike(' . 
                                                                        $this->id . 
                                                                        ', 1)"><i class="fa-solid fa-thumbs-up"></i></a>
                        <a id="btn_dislike_'. $this->id . $_SESSION[User::$UserSessionId] .'" class="btn '. ($like->value == -1 ? 'btn-danger' : 'btn-secondary') .'" onclick="addOrUpdateLike(' . 
                                                                        $this->id . 
                                                                        ', -1)"><i class="fa-solid fa-thumbs-down"></i></a>';
                    }
        $topicHtml .= '
                    </div>
                </div>
                <div class="card-footer text-muted container">
                    <div class="row">
                        <p class="col text-start">
                            created on '
                            .
                                htmlentities($this->creation_timestamp)
                            .   
                        '</p>
                        <p class="col text-end">
                            updated on '
                            .
                                htmlentities($this->update_timestamp)
                            .   
                        '</p>
                    </div>
                </div>
            </div>';

        return $topicHtml;
    }
    
    /**
     * getAsBootstrapGridForTopicPage
     *
     * @return string That contains the HTML code for displaying the topic in the topicpage
     */
    public function getAsBootstrapGridForTopicPage()
    {
        $deletePath = Helper::createUrl("topic_delete") . "?id=" . htmlentities($this->id);
        $editPath = Helper::createUrl("topic_update") . "?id=" . htmlentities($this->id);

        $topicHtml = 
            '<div class="col-sm m-1 card mt-3">
                <div class="card-body">
                    <p class="card-text">'
                    .
                        htmlentities($this->content)
                    .
                    '</p>';
        $topicHtml .= '
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">';
                        

        // If the user is logged in
        if(isset($_SESSION[User::$UserSessionId]))
        {
            $like = TopicLike::fetchByUserIdAndTopicId($_SESSION[User::$UserSessionId], $this->id)[0];
                $topicHtml .= 
                        '<a id="btn_like_'. $this->id . $_SESSION[User::$UserSessionId] .'" class="btn ' . ($like->value == 1 ? 'btn-danger' : 'btn-secondary') . '" onclick="addOrUpdateLike(' . 
                                                                $this->id . 
                                                                ', 1)"><i class="fa-solid fa-thumbs-up"></i></a>
                        <a id="btn_dislike_'. $this->id . $_SESSION[User::$UserSessionId] .'" class="btn '. ($like->value == -1 ? 'btn-danger' : 'btn-secondary') .'" onclick="addOrUpdateLike(' . 
                                                                $this->id . 
                                                                ', -1)"><i class="fa-solid fa-thumbs-down"></i></a>';
            
            // If the logged in user owns the topic
            if($_SESSION[User::$UserSessionId] == $this->fk_user)
            {
                $topicHtml .= '
                        <a href="/'. $editPath .'" class="btn btn-secondary"><i class="fa-solid fa-pen"></i></a>
                        <a href="/'. $deletePath .'" class="btn btn-danger"><i class="fa-solid fa-trash-can"></i></a>';
            }
        }
        $topicHtml .= '
                    </div>
                </div>
                <div class="card-footer text-muted container">
                    <div class="row">
                        <p class="col text-start">
                            created on '
                            .
                                htmlentities($this->creation_timestamp)
                            .   
                        '</p>
                        <p class="col text-end">
                            updated on '
                            .
                                htmlentities($this->update_timestamp)
                            .   
                        '</p>
                    </div>
                </div>
            </div>';

        return $topicHtml;
    }
    
    /**
     * getTitleForTopicPage
     *
     * @return string
     */
    public function getTitleForTopicPage()
    {
        return htmlentities($this->name) . ', created by ' . htmlentities($this->whoWroteTopic());
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
            'rank' => $this->rank,
            'status' => $this->status,
            "private_key" => $this->private_key,
            "comments_on" => $this->comments_on
        ];

        Model::update("topic", $this->id, $params);
        Helper::redirect(Helper::createUrl("topic_show") . "?id=" . $this->id);
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