<?php
require_once 'config/db.php';
require_once 'models/NganhHoc.php';

class NganhHocController {
    private $nganh_hoc;

    public function __construct() {
        global $conn;
        $this->nganh_hoc = new NganhHoc($conn);
    }

    // Hiển thị danh sách ngành học
    public function index() {
        $stmt = $this->nganh_hoc->getAll();
        $result = $stmt->get_result();
        $nganh_hoc_list = [];
        while ($row = $result->fetch_assoc()) {
            $nganh_hoc_list[] = $row;
        }
        $stmt->close();
        require_once 'view/nganh_hoc/index.php';
    }

    // Hiển thị form thêm mới
    public function create() {
        require_once 'view/nganh_hoc/create.php';
    }

    // Lưu ngành học mới
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->nganh_hoc->MaNganh = $_POST['MaNganh'];
            $this->nganh_hoc->TenNganh = $_POST['TenNganh'];

            if ($this->nganh_hoc->create()) {
                header('Location: nganh_hoc.php');
            } else {
                echo "Lỗi: Không thể thêm ngành học mới.";
            }
        }
    }

    // Hiển thị form sửa
    public function edit() {
        if (isset($_GET['id'])) {
            $this->nganh_hoc->MaNganh = $_GET['id'];
            if ($this->nganh_hoc->getOne()) {
                $nganh_hoc = [
                    'MaNganh' => $this->nganh_hoc->MaNganh,
                    'TenNganh' => $this->nganh_hoc->TenNganh
                ];
                require_once 'view/nganh_hoc/edit.php';
            }
        }
    }

    // Cập nhật ngành học
    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->nganh_hoc->MaNganh = $_POST['MaNganh'];
            $this->nganh_hoc->TenNganh = $_POST['TenNganh'];

            if ($this->nganh_hoc->update()) {
                header('Location: nganh_hoc.php');
            } else {
                echo "Lỗi: Không thể cập nhật thông tin ngành học.";
            }
        }
    }

    // Xóa ngành học
    public function delete() {
        if (isset($_GET['id'])) {
            $this->nganh_hoc->MaNganh = $_GET['id'];
            if ($this->nganh_hoc->delete()) {
                header('Location: nganh_hoc.php');
            } else {
                echo "Lỗi: Không thể xóa ngành học. Có thể có sinh viên đang học ngành này.";
            }
        }
    }
}
?> 