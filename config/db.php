<?php

putenv("JAWSDB_URL=mysql://root@localhost:3306/proj_hinterland");
$db_info = parse_url(getenv("JAWSDB_URL"));
$path = str_replace("/", "", $db_info['path']);

return array(
  "db" => array(
    "provider" => $db_info['scheme'],
    "server" => array(
      "host" => $db_info['host'],
      "username" => $db_info['user'],
      "password" => $db_info['pass'],
      "database" => $path,
      "prefix" => "ps_"
    )
  )
);

 ?>
