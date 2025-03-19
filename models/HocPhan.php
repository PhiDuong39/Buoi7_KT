<?php
class HocPhan {
    private $conn;
    private $table_name = "HocPhan";

    public $MaHP;
    public $TenHP;
    public $SoTC;
    public $HocKy;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Lấy danh sách học phần
    public function getAll() {
        $query = "SELECT * FROM HocPhan";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Lấy thông tin một học phần
    public function getOne() {
        $query = "SELECT * FROM HocPhan WHERE MaHP = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $this->MaHP);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            $this->MaHP = $row['MaHP'];
            $this->TenHP = $row['TenHP'];
            $this->SoTC = $row['SoTC'];
            $this->HocKy = $row['HocKy'];
            return true;
        }
        return false;
    }

    // Thêm học phần mới
    public function create() {
        global $conn;
        $query = "INSERT INTO " . $this->table_name . " (MaHP, TenHP, SoTC, HocKy) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssis", $this->MaHP, $this->TenHP, $this->SoTC, $this->HocKy);
        return $stmt->execute();
    }

    // Cập nhật học phần
    public function update() {
        global $conn;
        $query = "UPDATE " . $this->table_name . " SET TenHP = ?, SoTC = ?, HocKy = ? WHERE MaHP = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssis", $this->TenHP, $this->SoTC, $this->HocKy, $this->MaHP);
        return $stmt->execute();
    }

    // Xóa học phần
    public function delete() {
        global $conn;
        $query = "DELETE FROM " . $this->table_name . " WHERE MaHP = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $this->MaHP);
        return $stmt->execute();
    }
}
?> 