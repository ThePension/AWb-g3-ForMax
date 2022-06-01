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
        $owner_id = $_SESSION[User::$UserSessionId] ?? null;

        if($owner_id == null)
        {
            $_SESSION['error_title'] = "Can not create a topic";
            $_SESSION['error_description'] = "You must be logged in to create a topic";
            Helper::redirect(Helper::createUrl("login"));
        }

        $topic_name = $_POST['topic_name'] ?? ""; // Shorthand for 'isset() ? ... : ...'
        $topic_content = $_POST['topic_content'] ?? "";
        $topic_status = $_POST['topic_status'] ?? "";
        $topic_private_key = $_POST['topic_private_key'] ?? "";
        $topic_comments_on = (isset($_POST['topic_comments_on']) ? 1 : 0);

        if($topic_private_key != "")
        {
            $topic_private_key = password_hash($topic_private_key, PASSWORD_DEFAULT);
        }

        if($topic_name != "" && $topic_content != "" && $topic_status != "")
        {
            $topic = new Topic;
            $topic->name = $topic_name;
            $topic->content = $topic_content;
            $topic->creation_timestamp = date("Y-m-d H:i:s");
            $topic->update_timestamp = date("Y-m-d H:i:s");
            $topic->status = $topic_status;
            $topic->fk_user = $owner_id;
            $topic->private_key = $topic_private_key;
            $topic->comments_on = $topic_comments_on;

            // TODO
            $topic->rank = 0;

            try
            {
                $topic->save();

                $_SESSION['message_title'] = "Addition successful";
                $_SESSION['message_description'] = "The topic has been created.";

                Helper::redirect(Helper::createUrl("topic_show_all"));
            }
            catch (Exception $e)
            {
                $_SESSION['error_title'] = "Adding topic error";
                $_SESSION['error_description'] = "Unknown error : " . $e->getMessage();
                Helper::redirect(Helper::createUrl("topic_add"));
            }
        }
        else
        {
            $_SESSION['error_title'] = "Adding topic error";
            $_SESSION['error_description'] = "Missing information(s). Comments_on : " . $topic_comments_on;
            Helper::redirect(Helper::createUrl("topic_add"));
        }

        Helper::redirect(Helper::createUrl("topic_show_all"));
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
            $user_id = $_SESSION[User::$UserSessionId] ?? null;

            switch ($topic->status)
            {
                case 'HIDDEN':
                    if($user_id != $topic->fk_user)
                    {
                        Helper::redirect(Helper::createUrl("topic_show_all"));
                    }
                    break;

                case 'PRIVATE':
                    if($user_id != $topic->fk_user)
                    {
                        if(!isset($_SESSION['private_key_validation']) || $_SESSION['private_key_validation'] != "OK")
                        {
                            Helper::redirect(Helper::createUrl("topic_show_all"));
                        }
                    }
                    break;

                case 'PUBLIC':
                    // Nothing to do
                    break;
            }

            $comments = Comment::fetchAllByTopicIdOrderBy($id, "likes");

            return Helper::view("topic_show",[
                'topic' => $topic,
                'comments' => $comments
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
        $user_id = $_SESSION[User::$UserSessionId] ?? null;

        if($user_id == null)
        {
            $_SESSION['error_title'] = "Can not create a topic";
            $_SESSION['error_description'] = "You must be logged in to create a topic";
            Helper::redirect(Helper::createUrl("login"));
        }

        if(isset($_GET['id']))
        {
            $id = $_GET['id'];

            $topic = Topic::fetchId($id);

            if($topic->fk_user != $user_id)
            {
                $_SESSION['error_title'] = "Can not delete this topic";
                $_SESSION['error_description'] = "Only the owner can delete this topic";
                Helper::redirect(Helper::createUrl("topic_show_all"));
            }

            try
            {
                $topic->remove();

                $_SESSION['message_title'] = "Deletion successful";
                $_SESSION['message_description'] = "The topic has been deleted.";

                Helper::redirect(Helper::createUrl("topic_show_all"));
            }
            catch (Exception $e)
            {
                $_SESSION['error_title'] = "Deletion topic error";
                $_SESSION['error_description'] = "Unknown error : " . $e->getMessage();
                Helper::redirect(Helper::createUrl("topic_show_all"));
            }
            
            $topic->remove();
        }
        
        Helper::redirect(Helper::createUrl("topic_show_all"));
    }
    
    /**
     * showUpdateTopicView
     *
     * @return void
     */
    public function showUpdateTopicView()
    {
        $user_id = $_SESSION[User::$UserSessionId] ?? null;

        if($user_id == null)
        {
            $_SESSION['error_title'] = "Can not create a topic";
            $_SESSION['error_description'] = "You must be logged in to create a topic";
            Helper::redirect(Helper::createUrl("login"));
        }

        if(isset($_GET['id']))
        {
            $id = $_GET['id'];

            $topic = Topic::fetchId($id);

            if($topic->fk_user != $user_id)
            {
                $_SESSION['error_title'] = "Can not update this topic";
                $_SESSION['error_description'] = "Only the owner can update this topic";
                Helper::redirect(Helper::createUrl("topic_show_all"));
            }

            return Helper::view("topic_update",[
                'topic' => $topic
            ]);
        }
        else
        {
            Helper::redirect(Helper::createUrl("topic_show_all"));
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
                $topic_status = $_POST['topic_status'] ?? "";
                $topic_private_key = $_POST['topic_private_key'] ?? "";
                $topic_comments_on = (isset($_POST['topic_comments_on']) ? 1 : 0);

                if(!$topic_comments_on)
                {
                    // Delete all comments related to the topic
                    $comments = Comment::fetchByTopicId($topic->id);

                    foreach($comments as $comment)
                    {
                        try
                        {
                            $comment->remove();
                        }
                        catch (Exception $e)
                        {

                        }
                    }
                }

                if($topic_private_key != "")
                {
                    // If the private key has been updated, hash it
                    $topic_private_key = password_hash($topic_private_key, PASSWORD_DEFAULT);
                    $topic->private_key = $topic_private_key;
                }
        
                if($topic_name != "" && $topic_content != "" && $topic_status != "")
                {
                    $topic->name = $topic_name;
                    $topic->content = $topic_content;
                    $topic->status = $topic_status;
                    $topic->comments_on = $topic_comments_on;

                    if($topic->status != "PRIVATE")
                    {
                        $topic->private_key = null;
                    }
                    
                    try
                    {
                        $topic->modify();
        
                        $_SESSION['message_title'] = "Modification successful";
                        $_SESSION['message_description'] = "The topic has been modified.";
        
                        Helper::redirect(Helper::createUrl("topic_show_all"));
                    }
                    catch (Exception $e)
                    {
                        $_SESSION['error_title'] = "Modification topic error";
                        $_SESSION['error_description'] = "Unknown error : " . $e->getMessage();
                        Helper::redirect(Helper::createUrl("topic_show_all"));
                    }
                }
                else
                {
                    $_SESSION['error_title'] = "Topic modification error";
                    $_SESSION['error_description'] = "Invalid argument(s)";
                    Helper::redirect(Helper::createUrl("topic_show_all"));
                }
            }
        }
        Helper::redirect(Helper::createUrl("topic_show_all"));
    }
    
    /**
     * showAllTopics
     *
     * @return void
     */
    public function showAllTopics()
    {
        $topics = Topic::fetchAllOrderBy("rank DESC");        

        $public_topics = array_filter($topics, function($topic) use (&$search) {
            return $topic->status == "PUBLIC";
        });

        // SEARCH PARAMETER
        if(isset($_GET['search']))
        {
            $search = trim($_GET['search']);

            if($search != "")
            {
                $public_topics = array_filter($public_topics, function($topic) use (&$search) {
                    return (strstr($topic->name, $search) || strstr($topic->content, $search)) !== false && $topic->status == "PUBLIC";
                });
            }

            // Display message if no result found
            if(count($public_topics) == 0)
            {
                $_SESSION['message_title'] = "Search result";
                $_SESSION['message_description'] = "No result found.";
            }
        }

        return Helper::view("topic_show_all",[
            'topics' => $public_topics
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

    /**
     * showMyTopics
     *
     * @return void
     */
    public function showMyTopics()
    {
        $user_id = $_SESSION[User::$UserSessionId] ?? null;

        if($user_id == null)
        {
            $_SESSION['error_title'] = "Can not access your topics";
            $_SESSION['error_description'] = "You must be logged in to access your topics";
            Helper::redirect(Helper::createUrl("login"));
        }

        $topics = Topic::fetchAll();

        $topics = array_filter($topics, function($topic) use (&$user_id) {
            return $topic->fk_user == $user_id;
        });

        return Helper::view("topic_show_all",[
            'topics' => $topics
        ]);
    }

    public function showSubscribe()
    {
        return Helper::view("topic_subscribe");
    }

    public function subscribe()
    {
        $user_id = $_SESSION[User::$UserSessionId] ?? null;
        $private_topic_key = $_POST['private_topic_key'] ?? null;
        unset($_SESSION['private_key_validation']);

        if($user_id == null)
        {
            $_SESSION['error_title'] = "Can not subscribe to private topic";
            $_SESSION['error_description'] = "You must be logged in to access this feature";
            Helper::redirect(Helper::createUrl("login"));
        }

        if($private_topic_key == null)
        {
            $_SESSION['error_title'] = "Can not subscribe";
            $_SESSION['error_description'] = "You must enter a private topic key";
            Helper::redirect(Helper::createUrl("topic_subscribe"));
        }

        $topics = Topic::fetchAll();

        $private_topic = array_filter($topics, function($topic) use (&$private_topic_key) {
            return password_verify($private_topic_key, $topic->private_key);
        });

        if($private_topic == null)
        {
            $_SESSION['error_title'] = "Can not subscribe";
            $_SESSION['error_description'] = "You must enter a valid private topic key";
            Helper::redirect(Helper::createUrl("topic_subscribe"));
        }

        $_SESSION['private_key_validation'] = "OK";
        $path_to_topic = Helper::createUrl("topic_show") . "?id=" . htmlentities(array_values($private_topic)[0]->id);
        Helper::redirect($path_to_topic);
    }
}