<?php

class CommentLike extends Model
{
    private $fk_user;
    private $fk_comment;

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
     * @return CommentLike array that contains all the likes of a comment
     */
    public static function fetchAll()
    {
        $allLikes = Model::readAll("commentlike", "CommentLike");

        return $allLikes; // TODO : Upgrade
    }

    /**
     * fetchByUserId
     *
     * @param  mixed $user_id The ID of the user
     * @return CommentLike array that contains all the liked topic by te user
     */
    public static function fetchByUserId($user_id)
    {
        // ASSUMPTION
        //    - $id was validated by the caller

        return Model::readByCriteria("commentlike", "CommentLike", "fk_user", $user_id);
    }

     /**
     * fetchByTopicId
     *
     * @param  mixed $topic_id The ID of the topic
     * @return CommentLike array that contains all the likes of the topic
     */
    public static function fetchByCommentId($comment_id)
    {
        // ASSUMPTION
        //    - $id was validated by the caller

        return Model::readByCriteria("commentlike", "CommentLike", "fk_comment", $comment_id);
    }

    /**
     * fetchByUserIdAndCommentId
     *
     * @param  mixed $topic_id The ID of the topic
     * @return CommentLike array that contains all the likes of the topic
     */
    public static function fetchByUserIdAndCommentId($user_id, $fk_comment)
    {
        $like_criterias = [
            "fk_user" => $user_id,
            "fk_comment" => $fk_comment
        ];

        return Model::readByCriterias("commentlike", "CommentLike", $like_criterias);
    }

    /**
     * save The like in the database
     *
     * @return void
     */
    public function save()
    {
        $like_values = [
            "fk_user" => $this->fk_user,
            "fk_comment" => $this->fk_comment
        ];

        Model::create("commentlike", $like_values);
    }

    /**
     * remove the CommentLike from the database
     *
     * @return void
     */
    public function remove()
    {
        $like_criterias = [
            "fk_user" => $this->fk_user,
            "fk_comment" => $this->fk_comment
        ];

        Model::deleteByCriteria('commentlike', $like_criterias);
    }
}