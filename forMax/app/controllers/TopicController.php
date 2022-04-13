<?php

class TopicController
{
    public function showAddTopicView()
    {
        return Helper::view("topic_add");
    }

    public function addTopic()
    {
        // TODO
    }

    public function showTopicView()
    {
        // TODO
        // ICI
        if(isset($_GET['id']))
        {
            $id = $_GET['id'];

            $topic = Topic::fetchId($id);

            return Helper::view("topic_show",[
                'topic' => $topic
            ]);
        }
    }

    public function deleteTopic()
    {
        // TODO
    }

    public function showUpdateTopicView()
    {
        // TODO
    }

    public function updateTopic()
    {
        // TODO
    }

    public function showAllTopics()
    {
        $topics = Topic::fetchAll();

        return Helper::view("topic_show_all",[
            'topics' => $topics
        ]);
    }

    public function makeFavorite()
    {
        // TODO
    }
}