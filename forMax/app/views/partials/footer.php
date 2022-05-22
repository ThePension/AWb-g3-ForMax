    
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
                    let btn_like = document.getElementById("btn_like");
                    let btn_dislike = document.getElementById("btn_dislike");

                    if(value_ == 1)
                    {
                        btn_like.classList.remove("btn-secondary");
                        btn_like.classList.add("btn-danger");

                        btn_dislike.classList.remove("btn-danger");
                        btn_dislike.classList.add("btn-secondary");
                    }
                    else
                    {
                        btn_like.classList.remove("btn-danger");
                        btn_like.classList.add("btn-secondary");

                        btn_dislike.classList.remove("btn-secondary");
                        btn_dislike.classList.add("btn-danger");
                    }
                }
            }
        </script>
    </body>
</html>
