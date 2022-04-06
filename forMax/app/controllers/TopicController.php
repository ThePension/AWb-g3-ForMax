<?php

require "app/models/Topic.php";

class TopicController
{
    public function showAddTopicView()
    {
        // TODO
    }

    public function addTopic()
    {
        // TODO
    }

    public function showTopicView()
    {
        // TODO
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
        // HERE
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