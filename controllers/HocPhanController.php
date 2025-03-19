<?php
require_once 'config/db.php';
require_once 'models/HocPhan.php';
require_once 'models/DangKyHocPhan.php';

class HocPhanController {
    private $hoc_phan;
    private $dang_ky;

    public function __construct() {
        global $conn;
        session_start();
        // Kiểm tra đăng nhập
        if (!isset($_SESSION['MaSV'])) {
            header('Location: auth.php');
            exit;
        }
        $this->hoc_phan = new HocPhan($conn);
        $this->dang_ky = new DangKyHocPhan($conn);
    }

    // Hiển thị danh sách học phần
    public function index() {
        $stmt = $this->hoc_phan->getAll();
        $result = $stmt->get_result();
        $hoc_phan_list = [];
        while ($row = $result->fetch_assoc()) {
            $hoc_phan_list[] = $row;
        }
        $stmt->close();
        require_once 'view/hoc_phan/index.php';
    }

    // Hiển thị danh sách học phần đã đăng ký
    public function myCourses() {
        $stmt = $this->dang_ky->getByStudent($_SESSION['MaSV']);
        $result = $stmt->get_result();
        $registered_courses = [];
        while ($row = $result->fetch_assoc()) {
            $registered_courses[] = $row;
        }
        $stmt->close();
        require_once 'view/hoc_phan/my_courses.php';
    }

    // Đăng ký học phần
    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->dang_ky->MaSV = $_SESSION['MaSV'];
            $this->dang_ky->MaHP = $_POST['MaHP'];

            if ($this->dang_ky->register()) {
                $_SESSION['success'] = "Đăng ký học phần thành công.";
                header('Location: hoc_phan.php?action=myCourses');
            } else {
                $_SESSION['error'] = "Lỗi: Không thể đăng ký học phần.";
                header('Location: hoc_phan.php');
            }
            exit;
        }
    }

    // Hủy đăng ký học phần
    public function unregister() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->dang_ky->MaSV = $_SESSION['MaSV'];
            $this->dang_ky->MaHP = $_POST['MaHP'];

            if ($this->dang_ky->unregister()) {
                $_SESSION['success'] = "Hủy đăng ký học phần thành công.";
                header('Location: hoc_phan.php?action=myCourses');
            } else {
                $_SESSION['error'] = "Lỗi: Không thể hủy đăng ký học phần.";
                header('Location: hoc_phan.php?action=myCourses');
            }
            exit;
        }
    }

    public function unregister_all() {
        if ($this->dang_ky->unregisterAll($_SESSION['MaSV'])) {
            $_SESSION['success'] = "Đã xóa tất cả học phần đã đăng ký.";
        } else {
            $_SESSION['error'] = "Có lỗi xảy ra khi xóa các học phần.";
        }
        
        header('Location: hoc_phan.php?action=myCourses');
        exit;
    }
}
?> 