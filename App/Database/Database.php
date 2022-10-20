<?php

namespace App\Database;

use PDO;
use PDOException;

class Database
{
    public PDO $pdo;
    public const FETCH_ASSOC = PDO::FETCH_ASSOC;
    private string $driver;
    private string $host;
    private string $userName;
    private string $password;
    private string $database;
    private string $port;
    private string $charset;

    /**
     * @throws \Exception
     */
    public function __construct(array $connection)
    {
        /** @var $driver */
        /** @var $host */
        /** @var $userName */
        /** @var $password */
        /** @var $database */
        /** @var $port */
        /** @var $charset */
        extract($connection);
        $this->driver = $driver;
        $this->host = $host;
        $this->userName = $userName;
        $this->password = $password;
        $this->database = $database;
        $this->port = $port;
        $this->charset = $charset;
        try {
            $this->pdo = new PDO(
                $this->driver . ':' .
                'host=' . $this->host . ';' .
                'port=' . $this->port . ';' .
                'dbname=' . $this->database . ';' .
                'charset=' . $this->charset,
                $this->userName,
                $this->password
            );
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            throw new \Exception('Unable connect to the DB ' . $e->getMessage(), 500);
        }
    }
}
