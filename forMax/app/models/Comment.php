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

    public function __set($property, $value)
    {
        $this->property= $value;
    }

    public function __get($property)
    {
        return $this->property;
    }

    public function getAsBootstrap()
    {
        // Design based on : https://mdbootstrap.com/docs/standard/extended/comments/
        $comment_html = "";

        $comment_html .= "
        <div class='card-body ps-4'>
            <div class='d-flex flex-start'>
                <div>
                    <h6 class='fw-bold mb-1'>". htmlentities($this->whoWroteComment()) ."</h6>
                    <div class='d-flex align-items-center mb-3'>
                        <p class='mb-0'>"
                        .
                        htmlentities($this->timestamp)
                        .
                        "</p>

                        <span class='ms-4'>". htmlentities($this->likes) . "</span>
                        <a href='#!' class='link-muted'><i class='fas fa-heart ms-2'></i></a>
                    </div>
                    <p class='mb-0'>"
                    . 
                    htmlentities($this->content)
                    .
                    "</p>
                </div>
            </div>
        </div>
            
        <hr class='my-0' />";

        return $comment_html;
    }

    /**
     * fetchByUserId
     *
     * @param  mixed $topic_id The ID of the topic
     * @return Comment array that contains all the comments of the topic
     */
    public static function fetchByTopicId($topic_id)
    {
        return Model::readByCriteria("comment", "Comment", "fk_topic", $topic_id);
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
}