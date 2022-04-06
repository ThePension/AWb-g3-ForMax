<?php

class Topic
{
    private $id;
    private $name;
    private $content;
    private $rank;
    private $update_timestamp;
    private $creation_timestamp;
    private $fk_user;

    public function __set($property, $value)
    {
        $this->property= $value;
    }

    public function __get($property)
    {
        return $this->property;
    }

    public function getAsBootstrapGridForHomePage()
    {
        $install_prefix = App::get('config')['install_prefix'];

        $pathToTheTopic = urlencode("/" + $install_prefix + "/topic_show?id=" + $this->id);

        $topicHtml = 
            "<div class='card'>
                <div class='card-header'>"
                +
                    htmlentities($this->name);
                +
                "</div>
                <div class='card-body'>
                    <p class='card-text text-truncate'>"
                    +
                        htmlentities($this->content);
                    +
                    "</p>
                    <a href='/"+ $pathToTheTopic +"' class='btn btn-info'>Read further</a>
                    <p>created on "
                    +
                        htmlentities($this->creation_timestamp);
                    +
                    " | updated on "
                    +
                        htmlentities($this->update_timestamp);
                    +
                    "</p>
                </div>
            </div>";

        return $topicHtml;
    }

    public function getAsBootstrapGridForTopicPage()
    {

    }
}