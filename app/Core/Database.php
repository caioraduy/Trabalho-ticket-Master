<?php

    namespace App\Core;

    use PDO;
    use PDOException;

    class Database{

        private static ?Database $instance = null;
        private PDO $connection;

        private function __construct()
        {
            $config = require ROOT . '/config/database.php';

            $dsn = "mysql:host={$config['host']};dbname={$config['dbname']};charset={$config['charset']}";

            try {
                $this->connection = new PDO($dsn, $config['username'], $config['password'],[
                    PDO :: ATTR_ERRMODE => PDO :: ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES   => false,
                ]);
            } catch (PDOException $e) {
                die('Erro na conexão' . $e -> getMessage());
            }
        }
    

        public static function getInstance(): Database{
            if (self::$instance === null) {
                self::$instance = new Database();
            }
            return self::$instance;
        }

        public function getConnection(): PDO{
            return $this-> connection;
        }
    }
?>