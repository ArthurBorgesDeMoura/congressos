<?php

function mysqlConnect()
{
    $db_host = "localhost";
    $db_username = "root";
    $db_password = "";
    $db_name = "congressos";

    $dsn = "mysql:host=$db_host;dbname=$db_name;charset=utf8mb4";

    $options = [
        PDO::ATTR_EMULATE_PREPARES => false,
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_PERSISTENT    => true,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ];

    try {
        $conn = new PDO($dsn, $db_username, $db_password, $options);
        return $conn;
    } catch (Exception $e) {

        exit('Falha na conexão com o BD: ' . $e->getMessage());
    }
}