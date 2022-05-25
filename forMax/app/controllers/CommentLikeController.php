<?php

class CommentLikeController
{
    public function AddOrRemoveLike()
    {    
        $content = trim(file_get_contents("php://input"));
        $decoded = json_decode($content, true);

        $comment_id = $decoded['comment_id'];

        if(isset($_SESSION[User::$UserSessionId]))
        {
            if($comment_id == "" || $comment_id == null)
            {
                $_SESSION['error_title'] = "Comment like error";
                $_SESSION['error_description'] = "This comment does not exist";
            }
            else
            {
                $user_id = $_SESSION[User::$UserSessionId];

                $commentLike = CommentLike::fetchByUserIdAndCommentId($user_id, $comment_id)[0];

                $comment = Comment::fetchByCommentId($comment_id);

                try
                {
                    if($commentLike != null)
                    {
                        // Delete the like
                        $commentLike->remove();

                        $comment->likes -= 1;
                        $comment->modify();
                    }
                    else
                    {
                        // Create a like
                        $commentLike = new CommentLike();
                        $commentLike->fk_user = $user_id;
                        $commentLike->fk_comment = $comment_id;

                        $commentLike->save();

                        $comment->likes += 1;
                        $comment->modify();
                    }

                    echo Helper::getAjaxResponse("Comment updation successful");
                }
                catch (Exception $e)
                {
                    echo Helper::getAjaxResponse($e->getMessage());
                }
            }
        }
        else
        {
            $_SESSION['error_title'] = "Like error";
            $_SESSION['error_description'] = "User must be logged in to like comments";
        }
    }
}