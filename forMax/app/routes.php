<?php

$router->define([
  // '' => 'controllers/index.php',  // by conventions all controllers are in 'controllers' folder
  '' => 'IndexController',
  'index' => 'IndexController',
  'about' => 'IndexController@about',
  'login' => 'UserController@showLoginView',
  'login_do' => 'UserController@login',
  'logout' => 'UserController@logout',
  'register' => 'UserController@showRegisterView',
  'register_do' => 'UserController@register',
  'topic_add' => 'TopicController@showAddTopicView',
  'topic_add_do' => 'TopicController@addTopic',
  'topic_show' => 'TopicController@showTopicView',
  'topic_delete' => 'TopicController@deleteTopic',
  'topic_update' => 'TopicController@showUpdateTopicView',
  'topic_update_do' => 'TopicController@updateTopic',
  'topic_show_all' => 'TopicController@showAllTopics',
  'comment_add' => 'CommentController@addComment',
  'comment_update' => 'CommentController@updateComment',
  'comment_delete' => 'CommentController@removeComment',
  'topic_addFavorite' => 'TopicController@makeFavorite'
]);
