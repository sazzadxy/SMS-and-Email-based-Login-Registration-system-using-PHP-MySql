<?php

class Database  
{
    protected $pdo;
    protected static $instance;

    public function __construct()
    {
        $options = array(
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_PERSISTENT => true
        );

        try {
            $dsn = 'mysql:host='.DB_HOST.';dbname='.DB_NAME.'';
            $this->pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function instance()
    {
        if (self::$instance === null) {
            self::$instance = new self;
        }

        return self::$instance;
    }

    public function __call($methods, $args)
    {
         return call_user_func_array(array($this->pdo, $methods), $args);
    }
}



?>