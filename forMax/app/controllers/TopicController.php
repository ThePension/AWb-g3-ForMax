<?php

class TopicController
{
        
    /**
     * showAddTopicView
     *
     * @return void
     */
    public function showAddTopicView()
    {
        return Helper::view("topic_add");
    }
    
    /**
     * addTopic
     *
     * @return void
     */
    public function addTopic()
    {
        $install_prefix = App::get('config')['install_prefix'];

        $topic_name = $_POST['topic_name'] ?? ""; // Shorthand for 'isset() ? ... : ...'
        $topic_content = $_POST['topic_content'] ?? "";

        if($topic_name != "" && $topic_content != "")
        {
            $topic = new Topic;
            $topic->name = $topic_name;
            $topic->content = $topic_content;
            $topic->creation_timestamp = date("Y-m-d H:i:s");
            $topic->update_timestamp = date("Y-m-d H:i:s");

            // TODO
            $topic->rank = 0;

            $topic->save();
        }
        else
        {
            throw new Exception("Topic creation : incorrect argument(s)");
        }

        Helper::redirect($install_prefix . "/topic_show_all");
    }
    
    /**
     * showTopicView
     *
     * @return void
     */
    public function showTopicView()
    {
        if(isset($_GET['id']))
        {
            $id = $_GET['id'];

            $topic = Topic::fetchId($id);

            return Helper::view("topic_show",[
                'topic' => $topic
            ]);
        }
    }
    
    /**
     * deleteTopic
     *
     * @return void
     */
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
    
    /**
     * showUpdateTopicView
     *
     * @return void
     */
    public function showUpdateTopicView()
    {
        if(isset($_GET['id']))
        {
            $id = $_GET['id'];

            $topic = Topic::fetchId($id);

            return Helper::view("topic_update",[
                'topic' => $topic
            ]);
        }
    }
    
    /**
     * updateTopic
     *
     * @return void
     */
    public function updateTopic()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST')
        {
            if(isset($_POST['id']))
            {
                $topic = Topic::fetchId($_POST['id']);

                $topic_name = $_POST['topic_name'] ?? "";
                $topic_content = $_POST['topic_content'] ?? "";
        
                if($topic_name != "" && $topic_content != "")
                {
                    $topic->name = $topic_name;
                    $topic->content = $topic_content;
        
                    $topic->modify();
                }
                else
                {
                    throw new Exception("Topic modification : incorrect argument(s)");
                }
            }
        }

        $install_prefix = App::get('config')['install_prefix'];
        Helper::redirect($install_prefix . "/topic_show_all");
    }
    
    /**
     * showAllTopics
     *
     * @return void
     */
    public function showAllTopics()
    {
        $topics = Topic::fetchAll();

        // SEARCH PARAMETER
        if(isset($_GET['search']))
        {
            $search = trim($_GET['search']);

            if($search != "")
            {
                $topics = array_filter($topics, function($topic) use (&$search) {
                    return (strstr($topic->name, $search) || strstr($topic->content, $search)) !== false;
                 });
            }
        }

        return Helper::view("topic_show_all",[
            'topics' => $topics
        ]);
    }
    
    /**
     * makeFavorite
     *
     * @return void
     */
    public function makeFavorite()
    {
        // TODO
    }
}