<?php
define( 'MY_ROOT',$_SERVER['DOCUMENT_ROOT'] . '/ns/Test' );

include 'Autoload.php';

Autoload::setFileExts( ['php', 'php7', 'de'] );
//Autoload::addFileExt( 'php' );
//Autoload::addNameSpace( 'App', MY_ROOT . '/App' );

Autoload::setNamespaces( [
  'Core'        => MY_ROOT . '/Core',
  'MyException' => MY_ROOT . '/Core/Exception',
  'App'         => MY_ROOT . '/App',
  'Tr'          => MY_ROOT . '/Library/Lib1',
] );

spl_autoload_register( ['\Autoload', 'loadClass' ] );

new App\Controller\BaseController;
new App\Controller\AdminController;
new App\Controller\UserController;
new App\Model\BaseModel;
new Core\Database\Connection();
new Core\Database\MysqlAdapter();
new \Tr\Translate();
new \Tr\Translite();
new \MyException\BaseException;