<?php
class DB
{
    private $host = "localhost";
    private $user = "root";
    private $dbname = "lab iti";
    private $pass = "";
    private $conn = null;

    function __construct()
    {
        $dsn = "mysql:host=$this->host;dbname=$this->dbname;charset=utf8";
        $this->conn = new PDO($dsn, $this->user, $this->pass);
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    function getConnection()
    {
        return $this->conn;
    }

    function getAllData($table)
    {
        $stmt = $this->conn->prepare("SELECT * FROM $table");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function getUserData($table, $id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM $table WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    function deleteUser($table, $id)
    {
        $stmt = $this->conn->prepare("DELETE FROM $table WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }


    function addUser($table, $data) {
        $columns = implode(", ", array_keys($data));
        $placeholders = ":" . implode(", :", array_keys($data));
        $sql = "INSERT INTO $table ($columns) VALUES ($placeholders)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute($data);
    }

    function updateUser($table, $data, $id) {
        $columns = "";
        foreach ($data as $key => $value) {
            $columns .= "$key = :$key, ";
        }
        $columns = rtrim($columns, ", ");
        $sql = "UPDATE $table SET $columns WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $data['id'] = $id;
        return $stmt->execute($data);
    }


}
