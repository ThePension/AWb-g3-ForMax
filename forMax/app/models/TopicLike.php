<?php

class TopicLike extends Model
{
    private $fk_user;
    private $fk_topic;
    private $value; // 1 = Like, -1 = Dislike

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
     * @return Like array that contains all the likes
     */
    public static function fetchAll()
    {
        $allLikes = Model::readAll("topiclike", "TopicLike");

        return $allLikes; // TODO : Upgrade
    }

    /**
     * fetchByUserId
     *
     * @param  mixed $user_id The ID of the user
     * @return TopicLike array that contains all the liked topic by te user
     */
    public static function fetchByUserId($user_id)
    {
        // ASSUMPTION
        //    - $id was validated by the caller

        return Model::readByCriteria("topiclike", "TopicLike", "fk_user", $user_id);
    }

     /**
     * fetchByTopicId
     *
     * @param  mixed $topic_id The ID of the topic
     * @return TopicLike array that contains all the likes of the topic
     */
    public static function fetchByTopicId($topic_id)
    {
        // ASSUMPTION
        //    - $id was validated by the caller

        return Model::readByCriteria("topiclike", "TopicLike", "fk_topic", $topic_id);
    }

    /**
     * fetchByUserIdAndTopicId
     *
     * @param  mixed $topic_id The ID of the topic
     * @return TopicLike array that contains all the likes of the topic
     */
    public static function fetchByUserIdAndTopicId($user_id, $topic_id)
    {
        $like_criterias = [
            "fk_user" => $user_id,
            "fk_topic" => $topic_id
        ];

        return Model::readByCriterias("topiclike", "TopicLike", $like_criterias);
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
            "fk_topic" => $this->fk_topic,
            "value" => $this->value
        ];

        Model::create("topiclike", $like_values);
    } 

    /**
     * modify the like in the database
     *
     * @return void
     */
    public function modify()
    {
        $criterias = [
            "fk_user" => $this->fk_user,
            "fk_topic" => $this->fk_topic
        ];

        $params = [
            "value" => $this->value
        ];

        Model::updateByCriterias("topiclike", $criterias, $params);
    }
}