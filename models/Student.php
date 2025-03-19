<?php
class Student {
    private $conn;
    private $table_name = "SinhVien";

    public $MaSV;
    public $HoTen;
    public $GioiTinh;
    public $NgaySinh;
    public $Hinh;
    public $MaNganh;
    public $TenNganh; // Để lưu tên ngành khi join với bảng NganhHoc

    public function __construct($db) {
        $this->conn = $db;
    }

    // Đọc tất cả sinh viên
    public function getAll() {
        $query = "SELECT sv.*, nh.TenNganh 
                FROM " . $this->table_name . " sv 
                LEFT JOIN NganhHoc nh ON sv.MaNganh = nh.MaNganh";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Tạo sinh viên mới
    public function create() {
        $query = "INSERT INTO " . $this->table_name . " 
                SET MaSV=?, HoTen=?, GioiTinh=?, NgaySinh=?, Hinh=?, MaNganh=?";
        $stmt = $this->conn->prepare($query);

        // Làm sạch dữ liệu
        $this->MaSV = htmlspecialchars(strip_tags($this->MaSV));
        $this->HoTen = htmlspecialchars(strip_tags($this->HoTen));
        $this->GioiTinh = htmlspecialchars(strip_tags($this->GioiTinh));
        $this->Hinh = htmlspecialchars(strip_tags($this->Hinh));
        $this->MaNganh = htmlspecialchars(strip_tags($this->MaNganh));

        // Bind các tham số
        $stmt->bind_param("ssssss", 
            $this->MaSV, 
            $this->HoTen, 
            $this->GioiTinh, 
            $this->NgaySinh, 
            $this->Hinh, 
            $this->MaNganh
        );

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Đọc thông tin một sinh viên
    public function getOne() {
        $query = "SELECT sv.*, nh.TenNganh 
                FROM " . $this->table_name . " sv 
                LEFT JOIN NganhHoc nh ON sv.MaNganh = nh.MaNganh 
                WHERE sv.MaSV = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $this->MaSV);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            $this->MaSV = $row['MaSV'];
            $this->HoTen = $row['HoTen'];
            $this->GioiTinh = $row['GioiTinh'];
            $this->NgaySinh = $row['NgaySinh'];
            $this->Hinh = $row['Hinh'];
            $this->MaNganh = $row['MaNganh'];
            $this->TenNganh = $row['TenNganh'];
            return true;
        }
        return false;
    }

    // Cập nhật sinh viên
    public function update() {
        $query = "UPDATE " . $this->table_name . " 
                SET HoTen=?, GioiTinh=?, NgaySinh=?, Hinh=?, MaNganh=? 
                WHERE MaSV=?";
        $stmt = $this->conn->prepare($query);

        // Làm sạch dữ liệu
        $this->MaSV = htmlspecialchars(strip_tags($this->MaSV));
        $this->HoTen = htmlspecialchars(strip_tags($this->HoTen));
        $this->GioiTinh = htmlspecialchars(strip_tags($this->GioiTinh));
        $this->Hinh = htmlspecialchars(strip_tags($this->Hinh));
        $this->MaNganh = htmlspecialchars(strip_tags($this->MaNganh));

        // Bind các tham số
        $stmt->bind_param("ssssss",
            $this->HoTen,
            $this->GioiTinh,
            $this->NgaySinh,
            $this->Hinh,
            $this->MaNganh,
            $this->MaSV
        );

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Xóa sinh viên
    public function delete() {
        // Xóa các bản ghi liên quan trong bảng DangKy trước
        $query = "DELETE FROM DangKy WHERE MaSV = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $this->MaSV);
        $stmt->execute();

        // Sau đó xóa sinh viên
        $query = "DELETE FROM " . $this->table_name . " WHERE MaSV = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $this->MaSV);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Lấy danh sách ngành học
    public function getNganhHoc() {
        $query = "SELECT * FROM NganhHoc";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
}
?> 