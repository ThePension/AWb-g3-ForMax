<?php

class CommentController
{
    public function addComment()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST')
        {
            $topic_id = $_POST['topic_id'] ?? null;

            if($topic_id == null)
            {
                $_SESSION['error_title'] = "Adding comment error";
                $_SESSION['error_description'] = "Invalid topic";
                Helper::redirect(Helper::createUrl("topic_show_all"));
            }

            $user_id = $_SESSION[User::$UserSessionId] ?? null;

            if($user_id == null)
            {
                $_SESSION['error_title'] = "Can not add a comment";
                $_SESSION['error_description'] = "You must be logged in to add a comment";
                Helper::redirect(Helper::createUrl("topic_show?id=" . $topic_id));
            }

            $comment_content = $_POST['comment_content'] ?? "";
            
            if($comment_content == "")
            {
                $_SESSION['error_title'] = "Incorrect inputs";
                $_SESSION['error_description'] = "Empty values";
                Helper::redirect(Helper::createUrl("topic_show?id=" . $topic_id));
            }

            $comment = new Comment();
            $comment->title = "TO DO"; // TO DO
            $comment->likes = 0;
            $comment->content = $comment_content;
            $comment->timestamp = date("Y-m-d H:i:s");
            $comment->fk_user = $user_id;
            $comment->fk_topic = $topic_id;

            try
            {
                $comment->save();
                Helper::redirect(Helper::createUrl("topic_show?id=" . $topic_id));
                $_SESSION['message_title'] = "Addition successful";
                $_SESSION['message_description'] = "The comment has been added.";
            }
            catch(Exception $e)
            {
                $_SESSION['error_title'] = "Adding comment error";
                $_SESSION['error_description'] = "Unknown error : " . $e->getMessage();
                Helper::redirect(Helper::createUrl("topic_show?id=" . $topic_id));
            }
            
        }
        Helper::redirect(Helper::createUrl("topic_show_all"));
    }

    public function updateComment()
    {
        // TODO
    }

    public function removeComment()
    {
        // TODO
    }
}