    
            </div>
        </main>

        <!-- Copyright -->
        <div class="b-example-divider"></div>

        <div class="container">
            <footer class="my-4 border-top">
                <div class="text-center p-3 text-dark">
                    © 2022 Copyright :
                    <a class="text-dark text-light" href="https://www.he-arc.ch"> HE-Arc.ch</a>
                </div>
            </footer>
        </div>
         <!-- Copyright -->

        <script>
            function close_box()
            {
                let elements = document.getElementsByClassName("info_box");
                for(var i = 0, length = elements.length; i < length; i++)
                {
                    elements[i].style.display = 'none';
                }
            }

            async function addOrUpdateLike(topic_id_, value_)
            {
                let install_prefix = '<?php echo App::get('config')['install_prefix']; ?>';
                let user_id = '<?php echo $_SESSION[User::$UserSessionId] ?>';

                var headers = {
                    "Content-Type": "application/json",                                                                                            
                    "Access-Control-Origin": "*"
                };

                var data = {
                    "topic_id": topic_id_,
                    "like_value": value_
                };

                let response = await fetch("/" + install_prefix + "/add_update_like_do", {
                    method: "POST",
                    credentials: "same-origin",
                    headers: headers,
                    body: JSON.stringify(data)
                });

                if(response.status == 200)
                {
                    // Update colors
                    let btn_like = document.getElementById("btn_like_" + topic_id_ + user_id);
                    let btn_dislike = document.getElementById("btn_dislike_" + topic_id_ + user_id);
                    let like_counter = document.getElementById("like_counter_" + topic_id_);

                    if(value_ == 1)
                    {
                        btn_like.classList.remove("btn-secondary");
                        btn_like.classList.add("btn-danger");

                        btn_dislike.classList.remove("btn-danger");
                        btn_dislike.classList.add("btn-secondary");

                        count = parseInt(like_counter.textContent);
                        like_counter.textContent = count + 1;
                    }
                    else
                    {
                        btn_like.classList.remove("btn-danger");
                        btn_like.classList.add("btn-secondary");

                        btn_dislike.classList.remove("btn-secondary");
                        btn_dislike.classList.add("btn-danger");

                        count = parseInt(like_counter.textContent);
                        like_counter.textContent = count - 1;
                    }
                }
            }

            async function comment_like(comment_id, topic_id)
            {
                let install_prefix = '<?php echo App::get('config')['install_prefix']; ?>';
                let user_id = '<?php echo $_SESSION[User::$UserSessionId] ?>';

                var headers = {
                    "Content-Type": "application/json",                                                                                            
                    "Access-Control-Origin": "*"
                };

                var data = {
                    "comment_id": comment_id
                };

                let response = await fetch("/" + install_prefix + "/comment_add_remove_like", {
                    method: "POST",
                    credentials: "same-origin",
                    headers: headers,
                    body: JSON.stringify(data)
                });

                console.log(response.json());

                if(response.status == 200)
                {
                    // Update colors
                    let btn_comment_like = document.getElementById("btn_comment_like_" + comment_id);
                    let like_counter = document.getElementById("likeCounter" + comment_id);

                    if(btn_comment_like.classList.contains("far"))
                    {
                        btn_comment_like.classList.remove("far");
                        btn_comment_like.classList.add("fas");

                        count = parseInt(like_counter.textContent);
                        like_counter.textContent = count + 1;
                    }
                    else
                    {
                        btn_comment_like.classList.remove("fas");
                        btn_comment_like.classList.add("far"); 

                        count = parseInt(like_counter.textContent);
                        like_counter.textContent = count - 1;
                    }
                }
            }

            function show_comment_update_form(comment_id)
            {
                let form_comment_like = document.getElementById("comment_update_form_" + comment_id);
                let btn_update_comment = document.getElementById("btn_update_comment_" + comment_id);
                let p_comment_content = document.getElementById("comment_content_" + comment_id);

                if(form_comment_like.classList.contains("d-none"))
                {
                    form_comment_like.classList.remove("d-none");
                    p_comment_content.classList.add("d-none");
                    btn_update_comment.textContent = "Abort";
                }
                else
                {
                    btn_update_comment.textContent = "Update";
                    form_comment_like.classList.add("d-none");
                    p_comment_content.classList.remove("d-none");
                }
            }
        </script>
    </body>
</html>
