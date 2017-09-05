<?php
require_once "{$_SERVER['DOCUMENT_ROOT']}/model/model/Adapters/FileAdapter.php";

class Blog extends FileAdapter
{
  protected $_target = 'blog';
  protected $_rules = [
    'id'    => ['blog_id',    'id'],
    'title' => ['blog_title', 'text', ['maxlength' => 50]],
    'text'  => ['blog_text',  'text', ['textarea' => true]],
  ];
}