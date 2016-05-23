<?php

session_start();

date_default_timezone_set("Asia/Manila");

require '../vendor/autoload.php';

$container = new \Slim\Container;

$container['config'] = function ($c) {
  return new \Noodlehaus\Config(array(
    "../config/db.php"
  ));
};
$capsule = new \Illuminate\Database\Capsule\Manager;
$capsule->addConnection(array(
  "driver" => $container['config']->get("db.provider"),
  "host" => $container['config']->get("db.server.host"),
  "database" => $container['config']->get("db.server.database"),
  "username" => $container['config']->get("db.server.username"),
  "password" => $container['config']->get("db.server.password"),
  "charset" => "utf8",
  "collation" => "utf8_unicode_ci",
  "prefix" => $container['config']->get("db.server.prefix")
));
$capsule->setAsGlobal();
$capsule->bootEloquent();
$container['db'] = function($c) use ($capsule) {
  return $capsule;
};

$container['flash'] = function ($c) {
    return new \Slim\Flash\Messages();
};

$container['view'] = function ($c) {
  $view = new \Slim\Views\Twig('../views');

  $view->addExtension(new \Slim\Views\TwigExtension(
    $c['router'],
    $c['request']->getUri()
  ));

  return $view;
};

$app = new \Slim\App($container);

require 'routes.php';

?>
