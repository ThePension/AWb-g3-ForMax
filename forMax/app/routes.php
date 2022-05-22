<?php

$router->define([
  '' => 'IndexController',
  'index' => 'IndexController',
  'about' => 'IndexController@about',
  'login' => 'UserController@showLoginView',
  'login_do' => 'UserController@login',
  'logout' => 'UserController@logout',
  'register' => 'UserController@showRegisterView',
  'register_do' => 'UserController@register',
  'guest' => 'UserController@guest',
  'topic_add' => 'TopicController@showAddTopicView',
  'topic_add_do' => 'TopicController@addTopic',
  'topic_show' => 'TopicController@showTopicView',
  'topic_delete' => 'TopicController@deleteTopic',
  'topic_update' => 'TopicController@showUpdateTopicView',
  'topic_update_do' => 'TopicController@updateTopic',
  'topic_show_all' => 'TopicController@showAllTopics',
  'topic_subscribe' => 'TopicController@showSubscribe',
  'topic_subscribe_do' => 'TopicController@subscribe',
  'comment_add' => 'CommentController@addComment',
  'comment_update' => 'CommentController@updateComment',
  'comment_delete' => 'CommentController@removeComment',
  'topic_addFavorite' => 'TopicController@makeFavorite',
  'account' => 'UserController@account',
  'my_topics' => 'TopicController@showMyTopics',
  'add_update_like_do' => 'LikeController@addOrUpdateLike'
]);
