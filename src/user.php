<?php

namespace App;

use PDO;

class user{
    private $conn;
    private $table = 'users';

    public function __construct($db){
        $this->conn=$db;
    }

    public function create($name, $email) {
        $sql = "INSERT INTO $this->table (name, email) VALUES (:name, :email)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Read all users
    public function readAll() {
        $sql = "SELECT * FROM $this->table ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Read a single user by ID
    public function readById($id) {
        $sql = "SELECT * FROM $this->table WHERE id = :id LIMIT 0,1";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Update user
    public function update($id, $name, $email) {
        $sql = "UPDATE $this->table SET name = :name, email = :email WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Delete user
    public function delete($id) {
        $sql = "DELETE FROM $this->table WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}