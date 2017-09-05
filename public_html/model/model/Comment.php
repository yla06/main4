<?php
require_once "{$_SERVER['DOCUMENT_ROOT']}/model/model/Adapters/MySQLAdapter.php";

class Comment extends MySQLAdapter
{
  protected $_target = 'comment';
  protected $_rules = [
    'id'   => ['comment_id',   'id'],
    'name' => ['comment_name', 'text', ['maxlength' => 20]],
    'text' => ['comment_text', 'text', ['textarea' => true]],
  ];
}