<?php

class Comment extends Model
{
    private $id;
    private $title;
    private $likes;
    private $content;
    private $timestamp;
    private $fk_user;
    private $fk_topic;

    /**
     * __set
     *
     * @param  mixed $property Is the property name
     * @param  mixed $value is the value to be set
     * @return void
     */
    public function __set($property, $value)
    {
        $this->$property = $value;
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

    public function getAsBootstrap()
    {
        // Design based on : https://mdbootstrap.com/docs/standard/extended/comments/
        $comment_html = "";

        $user_id = $_SESSION[User::$UserSessionId] ?? null;

        $comment_html .= "
        <hr class='my-0' />

        <div class='card-body ps-4'>";
        
        if($user_id == $this->fk_user)
        {
            $comment_html .= "
            <div class='float-end'>
                <a href='/". Helper::createUrl("comment_delete?comment_id=" . $this->id . "&topic_id=" . $this->fk_topic) ."'>
                    <button class='btn btn-info btn-sm text-light'>Delete</button>
                </a>
            </div>";
        }

        $commentLike = CommentLike::fetchByUserIdAndCommentId($user_id, $this->id);
        
        $comment_html .= "
            <h6 class='fw-bold mb-1'>". htmlentities($this->whoWroteComment()) ."</h6>
            <div class='d-flex align-items-center mb-3'>
                <p class='mb-0'>"
                .
                htmlentities($this->timestamp)
                .
                "</p>

                <span class='ms-4' id='likeCounter". $this->id ."'>". htmlentities($this->likes) . "</span>
                <a onclick='comment_like(". $this->id . ", " . $this->topic_id . ")' class='link-muted'>
                    <i id='btn_comment_like_" . $this->id . "' class='" . ($commentLike == null ? "far" : "fas") . " fa-heart ms-2'></i>
                </a>
            </div>
            <p class='mb-0 d-block'>"
            . 
            htmlentities($this->content)
            .
            "</p>
        </div>";

        return $comment_html;
    }

    /**
     * fetchByTopicId
     *
     * @param  mixed $topic_id The ID of the topic
     * @return Comment array that contains all the comments of the topic
     */
    public static function fetchByTopicId($topic_id)
    {
        return Model::readByCriteria("comment", "Comment", "fk_topic", $topic_id);
    }

    /**
     * fetchByUserId
     *
     * @param  mixed $topic_id The ID of the topic
     * @return Comment array that contains all the comments of the topic
     */
    public static function fetchByCommentId($comment_id)
    {
        return Model::readByCriteria("comment", "Comment", "id", $comment_id);
    }

    /**
     * whoWroteComment
     *
     * @return string the author of the topic
     */
    private function whoWroteComment()
    {
        $user = User::fetchId($this->fk_user);
        return $user->username;
    }

    /**
     * save The commment in the database
     *
     * @return void
     */
    public function save()
    {
        $comment_values = [
            "title" => $this->title,
            "likes" => $this->likes,
            "content" => $this->content,
            "timestamp" => $this->timestamp,
            "fk_user" => $this->fk_user,
            "fk_topic" => $this->fk_topic,
        ];

        Model::create("comment", $comment_values);
    } 

    /**
     * remove the comment from the database
     *
     * @return void
     */
    public function remove()
    {
        Model::delete('comment', $this->id);
    }

    /**
     * modify the comment in the database
     *
     * @return void
     */
    public function modify()
    {
        $comment_values = [
            "title" => $this->title,
            "likes" => $this->likes,
            "content" => $this->content,
            "timestamp" => $this->timestamp,
            "fk_user" => $this->fk_user,
            "fk_topic" => $this->fk_topic,
        ];

        Model::update("comment", $this->id, $comment_values);
    }
}