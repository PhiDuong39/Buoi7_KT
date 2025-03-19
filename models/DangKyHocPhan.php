<?php
class DangKyHocPhan {
    private $conn;
    public $MaSV;
    public $MaHP;
    
    public function __construct($conn) {
        $this->conn = $conn;
    }
    
    // Lấy danh sách học phần đã đăng ký của Student
    public function getByStudent($maSV) {
        $query = "SELECT hp.MaHP, hp.TenHP, hp.SoTinChi AS SoTC
                 FROM DangKy dk
                 JOIN ChiTietDangKy ct ON dk.MaDK = ct.MaDK
                 JOIN HocPhan hp ON ct.MaHP = hp.MaHP
                 WHERE dk.MaSV = ?";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $maSV);
        $stmt->execute();
        
        return $stmt;
    }
    
    // Đăng ký học phần mới
    public function register() {
        // Kiểm tra xem Student đã đăng ký học phần này chưa
        if ($this->isRegistered()) {
            return false; // Đã đăng ký rồi
        }
        
        // Bắt đầu transaction
        $this->conn->begin_transaction();
        
        try {
            // Kiểm tra xem đã có bản ghi đăng ký nào cho Student này chưa
            $queryCheck = "SELECT MaDK FROM DangKy WHERE MaSV = ?";
            $stmtCheck = $this->conn->prepare($queryCheck);
            $stmtCheck->bind_param("s", $this->MaSV);
            $stmtCheck->execute();
            $result = $stmtCheck->get_result();
            
            if ($result->num_rows == 0) {
                // Chưa có đăng ký nào, tạo mới
                $queryInsertDK = "INSERT INTO DangKy (NgayDK, MaSV) VALUES (NOW(), ?)";
                $stmtInsertDK = $this->conn->prepare($queryInsertDK);
                $stmtInsertDK->bind_param("s", $this->MaSV);
                $stmtInsertDK->execute();
                $maDK = $this->conn->insert_id;
                $stmtInsertDK->close();
            } else {
                // Đã có đăng ký, lấy MaDK
                $row = $result->fetch_assoc();
                $maDK = $row['MaDK'];
            }
            $stmtCheck->close();
            
            // Thêm chi tiết đăng ký
            $queryInsertCT = "INSERT INTO ChiTietDangKy (MaDK, MaHP) VALUES (?, ?)";
            $stmtInsertCT = $this->conn->prepare($queryInsertCT);
            $stmtInsertCT->bind_param("is", $maDK, $this->MaHP);
            $stmtInsertCT->execute();
            $stmtInsertCT->close();
            
            // Commit transaction
            $this->conn->commit();
            return true;
        } catch (Exception $e) {
            // Rollback khi có lỗi
            $this->conn->rollback();
            return false;
        }
    }
    
    // Kiểm tra xem Student đã đăng ký học phần này chưa
    private function isRegistered() {
        $query = "SELECT COUNT(*) as count
                 FROM DangKy dk
                 JOIN ChiTietDangKy ct ON dk.MaDK = ct.MaDK
                 WHERE dk.MaSV = ? AND ct.MaHP = ?";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ss", $this->MaSV, $this->MaHP);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $stmt->close();
        
        return $row['count'] > 0;
    }
    
    // Hủy đăng ký học phần
    public function unregister() {
        try {
            // Tìm MaDK của sinh viên
            $queryDK = "SELECT MaDK FROM DangKy WHERE MaSV = ?";
            $stmtDK = $this->conn->prepare($queryDK);
            $stmtDK->bind_param("s", $this->MaSV);
            $stmtDK->execute();
            $result = $stmtDK->get_result();
            
            if ($result->num_rows == 0) {
                return false; // Không tìm thấy đăng ký
            }
            
            $row = $result->fetch_assoc();
            $maDK = $row['MaDK'];
            $stmtDK->close();
            
            // Xóa chi tiết đăng ký
            $queryDelete = "DELETE FROM ChiTietDangKy WHERE MaDK = ? AND MaHP = ?";
            $stmtDelete = $this->conn->prepare($queryDelete);
            $stmtDelete->bind_param("is", $maDK, $this->MaHP);
            $stmtDelete->execute();
            $result = $stmtDelete->affected_rows > 0;
            $stmtDelete->close();
            
            return $result;
        } catch (Exception $e) {
            return false;
        }
    }
    
    // Hủy tất cả đăng ký học phần của Student
    public function unregisterAll($maSV) {
        try {
            // Bắt đầu transaction
            $this->conn->begin_transaction();
            
            // Tìm MaDK của Student
            $queryDK = "SELECT MaDK FROM DangKy WHERE MaSV = ?";
            $stmtDK = $this->conn->prepare($queryDK);
            $stmtDK->bind_param("s", $maSV);
            $stmtDK->execute();
            $result = $stmtDK->get_result();
            
            if ($result->num_rows == 0) {
                return false; // Không tìm thấy đăng ký
            }
            
            $row = $result->fetch_assoc();
            $maDK = $row['MaDK'];
            $stmtDK->close();
            
            // Xóa tất cả chi tiết đăng ký
            $queryDeleteCT = "DELETE FROM ChiTietDangKy WHERE MaDK = ?";
            $stmtDeleteCT = $this->conn->prepare($queryDeleteCT);
            $stmtDeleteCT->bind_param("i", $maDK);
            $stmtDeleteCT->execute();
            $stmtDeleteCT->close();
            
            // Commit transaction
            $this->conn->commit();
            return true;
        } catch (Exception $e) {
            // Rollback khi có lỗi
            $this->conn->rollback();
            return false;
        }
    }
    
    // Lấy thông tin phiếu đăng ký của Student
    public function getRegistrationInfo($maSV) {
        $query = "SELECT dk.MaDK, dk.NgayDK, dk.MaSV, sv.HoTen, sv.MaNganh, ng.TenNganh
                 FROM DangKy dk
                 JOIN SinhVien sv ON dk.MaSV = sv.MaSV
                 JOIN NganhHoc ng ON sv.MaNganh = ng.MaNganh
                 WHERE dk.MaSV = ?";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $maSV);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        }
        return null;
    }
    
    // Lấy tổng số tín chỉ đã đăng ký của Student
    public function getTotalCredits($maSV) {
        $query = "SELECT SUM(hp.SoTinChi) as TotalCredits
                 FROM DangKy dk
                 JOIN ChiTietDangKy ct ON dk.MaDK = ct.MaDK
                 JOIN HocPhan hp ON ct.MaHP = hp.MaHP
                 WHERE dk.MaSV = ?";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $maSV);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row['TotalCredits'] ?: 0;
        }
        return 0;
    }
}
?>