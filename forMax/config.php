<?php

return [
  'database' => [
    'dbname' => 'aw2_formax',
    'username' => 'root',
    'password' => '', //'root' in MAMP //'' (empty) in easyPHP
    'connection' => 'mysql:host=localhost',
    'port' => ' 3306', // '8889' default port in MAMP //  '3306' in easyPHP
    'options' => [
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]
  ],
  // if your app is not in the server's /, decomment and adapt
  // (then you MUST use relative URLs everywhere)
  'install_prefix' => 'AW_2/awb-g3-formax/forMax', // Théo

];
