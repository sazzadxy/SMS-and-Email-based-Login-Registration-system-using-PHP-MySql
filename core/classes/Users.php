<?php

class Users
{
    private $db;

    public function __construct()
    {
        $this->db = Database::instance();
    }

    public function get($table, $fields = array())
    {
        $columns = implode(', ', array_keys($fields));
        $sql = "SELECT * FROM `{$table}` WHERE `{$columns}` = :{$columns}";
        if ($stmt = $this->db->prepare($sql)) {
            foreach ($fields as $key => $value) {
                $stmt->bindValue(":{$key}", $value);
            }
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_OBJ);
        }
    }

    public function delete($table, $fields = array())
    {
        $columns = implode(', ', array_keys($fields));
        $sql = "DELETE FROM `{$table}` WHERE `{$columns}` = :{$columns}";
        if ($stmt = $this->db->prepare($sql)) {
            foreach ($fields as $key => $value) {
                $stmt->bindValue(":{$key}", $value);
            }
            $stmt->execute();
        }
    }

    public function insert($table, $fields = array())
    {
        $columns = implode(", ", array_keys($fields));
        $values = ":".implode(", :", array_keys($fields));
    $sql = "INSERT INTO {$table} ({$columns}) VALUES ({$values})";
    if ($stmt = $this->db->prepare($sql)) {
        foreach ($fields as $key => $value) {
            $stmt->bindValue(":{$key}", $value);
        }
        $stmt->execute();
        return $this->db->lastInsertId();
    }
    }
    


    public function emailExists($email)
    {
        $email = $this->get('users', array('email' => $email));
        return ((!empty($email))) ? $email : false;
    }

    public function usernameExists($username)
    {
        $username = $this->get('users', array('username' =>  $username));
        return ((!empty($username))) ? $username : false;
    }

    public function update($table, $fields, $conditions)
    {
        $columns = '';
        $where = " WHERE ";
        $i = 1;
        foreach ($fields as $name => $value) {
            $columns .= "`{$name}` = :{$name}";
            if ($i < count($fields)) {
                $columns .= ", ";
            }
            $i++;
        }

        $sql = "UPDATE {$table} SET {$columns}";
        foreach ($conditions as $name => $value) {
            $sql .= "{$where} `{$name}` = :{$name}";
            $where = " AND ";
        }

        if ($stmt = $this->db->prepare($sql)) {
            foreach ($fields as $key => $value) {
                $stmt->bindValue(":{$key}", $value);
                foreach ($conditions as $key => $value) {
                    $stmt->bindValue(":{$key}", $value);
                }
            }
            $stmt->execute();
        }
    }

    public function hash($password)
    {
        return password_hash($password, PASSWORD_BCRYPT);
    }

    public function redirect($location)
    {
        header("Location:" . BASE_URL . $location);
    }

    public function userData($user_id)
    {
        return $this->get('users', array('user_id' => $user_id));
    }

    public function logout()
    {
        $_SESSION = array();
        //session_unset();
        session_destroy();
        $this->redirect('index.php');
    }

    public function isLoggedIn()
    {
        return (isset($_SESSION['user_id'])) ? true : false;
    }
}
