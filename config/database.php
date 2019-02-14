<?php
return [
/*
 ----++ PHP------------------------------------------------------------------
| Status do aplicativo
| ---------------------------------------L-U-C-I-A-N-O---C-H-A-R-L-E-S-------
 | development/production
 |
 | Aqui estao as configuracoes de conexoes de banco de dados para seu aplicativo.
 | Assim sera recuperado os dados de acesso ao banco de dados
| conforme o indice environment.
|
 */
  'environment' => environment('environment'),
/*
| ---------------------------------------------------------------------------
| Conexoes de banco de dados                    GRUPO ++ PHP
| ---------------------------------------------------------------------------
|
| Aqui estao as configuracoes de conexoes de banco de dados para seu aplicativo.
|
| Portanto, verifique se voce tem o driver para o banco de dados
| instalado em sua maquina antes de comecar o desenvolvimento.
|
   */
  'connections' => [
    'development' => [
      'host' => 'localhost',
      'port' => 3306,
      'database' => 'myframe',
      'username' => 'root',
      'password' => '',
      'unix_socket' => null,
      'options' => [
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
        PDO::ATTR_PERSISTENT => true
      ],
      'errmode' => PDO::ERRMODE_EXCEPTION,
      'fetch_mode' => PDO::FETCH_OBJ
    ],
    'production' => [
      'host' => 'localhost',
      'port' => 3306,
      'database' => 'grupo++',
      'username' => 'root',
      'password' => '',
      'unix_socket' => null,
      'options' => [
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
        PDO::ATTR_PERSISTENT => true
      ],
      'errmode' => PDO::ERRMODE_EXCEPTION,
      'fetch_mode' => PDO::FETCH_OBJ
    ]
  ]
];