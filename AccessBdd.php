<?php
namespace Core;

use PDO;
use PDOException;

class AccessBdd
{

    private static $instance = null;
    private $host;
    private $user;
    private $password;
    private $db_name;
    private $handle;

    private function __construct() {

        $this->host = 'host';
        $this->user = 'user';
        $this->password = 'password';
        $this->db_name = 'db_name';

        try {

            $this->handle = new PDO('mysql:host='.$this->host.';dbname='.$this->db_name.';charset=utf8mb4',
                                    $this->user, $this->password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

        } catch (PDOException $e) {
            die('Echec de la connexion : ' . $e->getMessage());
        }

    }

    public function getHandle() {
        return $this->handle;
    }

    public static function getInstance() {

        if (is_null(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

}
