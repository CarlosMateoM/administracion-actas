<?php

namespace aplicacion;

use PDO;
use PDOException;

class Database
{
    private static ?Database $instance = null;
    private ?PDO $conn = null;

    private function __construct(
        private string $host,
        private string $name,
        private string $user,
        private string $password
    ) {
    }

    public static function getInstance(): Database
    {
        if (self::$instance === null) {
            self::$instance = new Database(
                $_ENV["DB_HOST"],
                $_ENV["DB_NAME"],
                $_ENV["DB_USER"],
                $_ENV["DB_PASS"]
            );
        }

        return self::$instance;
    }

    public function getConnection(): ?PDO
    {
        if ($this->conn === null) {
            try {
                $this->conn = new PDO(
                    "mysql:host={$this->host};dbname={$this->name}",
                    $this->user,
                    $this->password
                );
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $this->conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
                $this->conn->setAttribute(PDO::ATTR_STRINGIFY_FETCHES, false);
            } catch (PDOException $e) {
                echo "Connection failed: " . $e->getMessage();
                return null;
            }
        }

        return $this->conn;
    }
}
