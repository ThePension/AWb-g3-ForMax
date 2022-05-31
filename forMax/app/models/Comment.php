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

    public function getAsBootstrap($owner_id)
    {
        // Design based on : https://mdbootstrap.com/docs/standard/extended/comments/
        $comment_html = "";

        $user_id = $_SESSION[User::$UserSessionId] ?? null;

        $comment_html .= "
        <hr class='my-0' />

        <div class='card-body ps-4'>";

        if($user_id == $this->fk_user || $user_id == $owner_id)
        {
            $comment_html .= "
            <div class='float-end'>
                <a href='/". Helper::createUrl("comment_delete?comment_id=" . $this->id . "&topic_id=" . $this->fk_topic) ."'>
                    <button class='btn btn-danger btn-sm text-light'>Delete</button>
                </a>
            </div>";
        }

        if($user_id == $this->fk_user)
        {
            $comment_html .= "
            <div class='float-end me-3'>
                <button id='btn_update_comment_". $this->id ."' class='btn btn-info btn-sm text-light' onclick='show_comment_update_form(". $this->id .")'>Update</button>
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
                <a " . 
                    ($user_id != null ? "onclick='comment_like(". $this->id . ", " . $this->topic_id . ")'" : "")
                    
                    . " class='link-muted'>
                    <i id='btn_comment_like_" . $this->id . "' class='" . ($commentLike == null ? "far" : "fas") . " fa-heart ms-2'></i>
                </a>
            </div>
            <p class='mb-0 d-block'>";
                if($user_id == $this->fk_user)
                {
                    $comment_html .= "
                <form method='post' action='comment_update' id='comment_update_form_". $this->id ."' class='mb-5 d-none'>
                    <div class='d-flex flex-start w-100'>
                        <div class='form-outline w-100'>
                            <textarea class='form-control' id='comment_content' name='comment_content' rows='4' required>". htmlentities($this->content) ."</textarea>
                        </div>
                    </div>
                    <input type='hidden' name='topic_id' id='topic_id' value='" . $this->fk_topic . "' />
                    <input type='hidden' name='comment_id' id='comment_id' value='" . $this->id . "' />
                    <div class='float-end mt-2 pt-1'>
                        <button type='submit' class='btn btn-info btn-sm text-light'>Update comment</button>
                    </div>
                </form>";
                }
                $comment_html .= "
                <p id='comment_content_" . $this->id . "'>"
                . 
                    htmlentities($this->content)
                .
                "</p>
            </p>
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
        return Model::readByCriteria("comment", "Comment", "id", $comment_id)[0];
    }

    public static function fetchAllByTopicIdOrderBy($topic_id, $column)
    {
        $comments = Model::readByCriteria("comment", "Comment", "fk_topic", $topic_id);
        usort($comments, function($comment1, $comment2)
        {
            return strcmp($comment1->likes, $comment2->likes);
        });

        return array_reverse($comments);
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