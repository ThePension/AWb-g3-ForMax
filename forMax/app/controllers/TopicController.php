<?php

class TopicController
{
    public function showAddTopicView()
    {
        return Helper::view("topic_add");
    }

    public function addTopic()
    {
        $install_prefix = $install_prefix = App::get('config')['install_prefix'];

        $topic_name = $_POST['topic_name'] ?? ""; // Shorthand for 'isset() ? ... : ...'
        $topic_content = $_POST['topic_content'] ?? "";

        if($topic_name != "" && $topic_content != "")
        {
            $topic = new Topic;
            $topic->name = $topic_name;
            $topic->content = $topic_content;
            $topic->creation_timestamp = date("Y-m-d H:i:s");
            $topic->update_timestamp = date("Y-m-d H:i:s");

            // TO DO
            $topic->rank = 0;

            $topic->save();
        }
        else
        {
            throw new Exception("Topic creation : incorrect argument(s)");
        }

        Helper::redirect($install_prefix . "/topic_show_all");
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
        if(isset($_GET['id']))
        {
            $id = $_GET['id'];

            $topic = Topic::fetchId($id);

            $topic->remove();
        }
        
        Helper::redirect(App::get('config')['install_prefix'] . "/topic_show_all");
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