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
                $_SESSION['message_title'] = "Addition successful";
                $_SESSION['message_description'] = "The comment has been added.";
                Helper::redirect(Helper::createUrl("topic_show?id=" . $topic_id));
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
        if ($_SERVER['REQUEST_METHOD'] === 'POST')
        {
            $topic_id = $_POST['topic_id'] ?? null;

            if($topic_id == null)
            {
                $_SESSION['error_title'] = "Updating comment error";
                $_SESSION['error_description'] = "Invalid topic";
                Helper::redirect(Helper::createUrl("topic_show_all"));
            }

            $comment_id = $_POST['comment_id'] ?? null;

            if($comment_id == null)
            {
                $_SESSION['error_title'] = "Updating comment error";
                $_SESSION['error_description'] = "Invalid comment";
                Helper::redirect(Helper::createUrl("topic_show?id=" . $topic_id));
            }

            $user_id = $_SESSION[User::$UserSessionId] ?? null;

            if($user_id == null)
            {
                $_SESSION['error_title'] = "Can not update comment";
                $_SESSION['error_description'] = "You must be logged in to update a comment";
                Helper::redirect(Helper::createUrl("topic_show?id=" . $topic_id));
            }

            $comment_content = $_POST['comment_content'] ?? "";
            
            if($comment_content == "")
            {
                $_SESSION['error_title'] = "Incorrect inputs";
                $_SESSION['error_description'] = "Empty values";
                Helper::redirect(Helper::createUrl("topic_show?id=" . $topic_id));
            }

            $comment = Comment::fetchByCommentId($comment_id);

            if($comment == null)
            {
                $_SESSION['error_title'] = "Updating comment error";
                $_SESSION['error_description'] = "This comment does not exist";
                Helper::redirect(Helper::createUrl("topic_show?id=" . $topic_id));
            }

            // If the logged in user is not the owner
            if($comment->fk_user != $user_id)
            {
                $_SESSION['error_title'] = "Updating comment error";
                $_SESSION['error_description'] = "You must be the owner of the comment to edit it.";
                Helper::redirect(Helper::createUrl("topic_show?id=" . $topic_id));
            }

            $comment->content = $comment_content;

            try
            {
                $comment->modify();
                $_SESSION['message_title'] = "Modification successful";
                $_SESSION['message_description'] = "The comment has been updated.";
                Helper::redirect(Helper::createUrl("topic_show?id=" . $topic_id));
            }
            catch(Exception $e)
            {
                $_SESSION['error_title'] = "Updating comment error";
                $_SESSION['error_description'] = "Unknown error : " . $e->getMessage();
                Helper::redirect(Helper::createUrl("topic_show?id=" . $topic_id));
            }
        }
        Helper::redirect(Helper::createUrl("topic_show_all"));
    }

    public function removeComment()
    {
        $topic_id = $_GET['topic_id'] ?? null;

        if($topic_id == null)
        {
            $_SESSION['error_title'] = "Removing comment error";
            $_SESSION['error_description'] = "Invalid topic";
            Helper::redirect(Helper::createUrl("topic_show_all"));
        }

        $comment_id = $_GET['comment_id'] ?? null;

        if($comment_id == null)
        {
            $_SESSION['error_title'] = "Removing comment error";
            $_SESSION['error_description'] = "Invalid comment";
            Helper::redirect(Helper::createUrl("topic_show?id=" . $topic_id));
        }

        $user_id = $_SESSION[User::$UserSessionId] ?? null;

        if($user_id == null)
        {
            $_SESSION['error_title'] = "Can not remove a comment";
            $_SESSION['error_description'] = "You must be logged in to remove one of your comments";
            Helper::redirect(Helper::createUrl("topic_show?id=" . $topic_id));
        }

        $comment = Comment::fetchByCommentId($comment_id);

        if($comment == null)
        {
            $_SESSION['error_title'] = "Removing comment error";
            $_SESSION['error_description'] = "This comment does not exist";
            Helper::redirect(Helper::createUrl("topic_show?id=" . $topic_id));
        }

        $topic = Topic::fetchId($comment->fk_topic);

        // If the logged in user is not the owner and is not the owner of the topic
        if($comment->fk_user != $user_id && $topic->fk_user != $user_id)
        {
            $_SESSION['error_title'] = "Deleting comment error";
            $_SESSION['error_description'] = "You must be the owner of the comment or the topic to delete this comment.";
            Helper::redirect(Helper::createUrl("topic_show?id=" . $topic_id));
        }

        try
        {
            $comment->remove();
            $_SESSION['message_title'] = "Deletion successful";
            $_SESSION['message_description'] = "The comment has been deleted.";
            Helper::redirect(Helper::createUrl("topic_show?id=" . $topic_id));
        }
        catch(Exception $e)
        {
            $_SESSION['error_title'] = "Removing comment error";
            $_SESSION['error_description'] = "Unknown error : " . $e->getMessage();
            Helper::redirect(Helper::createUrl("topic_show?id=" . $topic_id));
        }
        Helper::redirect(Helper::createUrl("topic_show_all"));
    }
}