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
        $topic_status = $_POST['topic_status'] ?? "";

        if($topic_name != "" && $topic_content != "" && $topic_status != "")
        {
            $topic = new Topic;
            $topic->name = $topic_name;
            $topic->content = $topic_content;
            $topic->creation_timestamp = date("Y-m-d H:i:s");
            $topic->update_timestamp = date("Y-m-d H:i:s");
            $topic->status = $topic_status;

            // TODO
            $topic->rank = 0;

            try
            {
                $topic->save();

                $_SESSION['message_title'] = "Addition successful";
                $_SESSION['message_description'] = "The topic has been created.";

                Helper::redirect($install_prefix . "/topic_show_all");
            }
            catch (Exception $e)
            {
                $_SESSION['error_title'] = "Adding topic error";
                $_SESSION['error_description'] = "Unknown error : " . $e->getMessage();
                Helper::redirect($install_prefix . "/topic_add");
            }
        }
        else
        {
            $_SESSION['error_title'] = "Adding topic error";
            $_SESSION['error_description'] = "Missing information(s)";
            Helper::redirect($install_prefix . "/topic_add");
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
        else
        {
            Helper::redirect(App::get('config')['install_prefix'] . "/topic_show_all");
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