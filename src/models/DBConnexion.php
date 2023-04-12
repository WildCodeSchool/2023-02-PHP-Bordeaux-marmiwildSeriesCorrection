<?php

namespace Src\Models;

use PDO;

class DBConnexion
{
    protected PDO $connection;

    public function __construct()
    {
        $this->connection = new PDO("mysql:host=" . SERVER . ";dbname=" . DATABASE . ";charset=utf8", USER, PASSWORD);
    }
}