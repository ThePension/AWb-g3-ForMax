<?php

class TopicLikeController
{
    public function addOrUpdateLike()
    {    
        $content = trim(file_get_contents("php://input"));
        $decoded = json_decode($content, true);

        $topic_id = $decoded['topic_id'];
        $like_value = $decoded['like_value'];

        if(!isset($_SESSION[User::$UserSessionId]))
        {
            $_SESSION['error_title'] = "Like error";
            $_SESSION['error_description'] = "User must be logged in to like topics";
            Helper::redirect(Helper::createUrl("topic_show?id=" . $topic_id));
        }

        if(!($like_value == 1 || $like_value == -1))
        {
            $_SESSION['error_title'] = "Like error";
            $_SESSION['error_description'] = "Incorrect value";
            Helper::redirect(Helper::createUrl("topic_show?id=" . $topic_id));
        }

        $user_id = $_SESSION[User::$UserSessionId];

        $like = TopicLike::fetchByUserIdAndTopicId($user_id, $topic_id)[0];

        $topic = Topic::fetchId($topic_id);
        $topic->rank += $like_value;

        if($like == null)
        {
            // Add like
            $like = new TopicLike();
            $like->fk_topic = $topic_id;
            $like->fk_user = $_SESSION[User::$UserSessionId];
            $like->value = $like_value;

            try
            {
                $like->save();

                $topic->modify();
            }
            catch (Exception $e)
            {
                $_SESSION['error_title'] = "Adding like error";
                $_SESSION['error_description'] = $e->getMessage();
            }
        }
        else
        {
            // Update like
            $like->value = $like_value;
            
            try
            {
                $like->modify();

                $topic->modify();
            }
            catch (Exception $e)
            {
                $_SESSION['error_title'] = "Updating like error";
                $_SESSION['error_description'] = $e->getMessage();
            }
        }
    }
}