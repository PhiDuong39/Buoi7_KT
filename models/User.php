<?php
class User {
    private $conn;
    public $MaSV;
    public $HoTen;
    public $Password;
    public $Email;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $query = "INSERT INTO Users (MaSV, HoTen, Password, Email) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ssss", $this->MaSV, $this->HoTen, $this->Password, $this->Email);
        return $stmt->execute();
    }

    public function login($username, $password) {
        $query = "SELECT * FROM SinhVien WHERE MaSV = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->fetch_assoc()) {
            return true;
        }
        return false;
    }
}
?> 