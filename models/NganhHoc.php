<?php
class NganhHoc {
    private $conn;
    private $table_name = "NganhHoc";

    public $MaNganh;
    public $TenNganh;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Lấy danh sách ngành học
    public function getAll() {
        $query = "SELECT * FROM NganhHoc";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Thêm ngành học mới
    public function create() {
        $query = "INSERT INTO NganhHoc SET MaNganh=?, TenNganh=?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ss", $this->MaNganh, $this->TenNganh);
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Cập nhật ngành học
    public function update() {
        $query = "UPDATE NganhHoc SET TenNganh=? WHERE MaNganh=?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ss", $this->TenNganh, $this->MaNganh);
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Xóa ngành học
    public function delete() {
        // Kiểm tra xem có sinh viên nào đang học ngành này không
        $query = "SELECT COUNT(*) as count FROM SinhVien WHERE MaNganh = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $this->MaNganh);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        if ($row['count'] > 0) {
            return false;
        }

        // Nếu không có sinh viên nào, thực hiện xóa ngành
        $query = "DELETE FROM NganhHoc WHERE MaNganh = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $this->MaNganh);
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Lấy thông tin một ngành học
    public function getOne() {
        $query = "SELECT * FROM NganhHoc WHERE MaNganh = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $this->MaNganh);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            $this->MaNganh = $row['MaNganh'];
            $this->TenNganh = $row['TenNganh'];
            return true;
        }
        return false;
    }
}
?> 