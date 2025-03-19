<?php
require_once 'config/db.php';
require_once 'models/Student.php';
require_once 'models/NganhHoc.php';

class StudentController {
    private $student;
    private $nganh_hoc;

    public function __construct() {
        global $conn;
        $this->student = new Student($conn);
        $this->nganh_hoc = new NganhHoc($conn);
    }

    // Hiển thị danh sách sinh viên
    public function index() {
        $stmt = $this->student->getAll();
        $stmt->store_result();
        $meta = $stmt->result_metadata();
        $fields = [];
        $row = [];
        while ($field = $meta->fetch_field()) {
            $fields[] = &$row[$field->name];
        }
        call_user_func_array([$stmt, 'bind_result'], $fields);
        
        $students = [];
        while ($stmt->fetch()) {
            $temp = [];
            foreach ($row as $key => $val) {
                $temp[$key] = $val;
            }
            $students[] = $temp;
        }
        $stmt->free_result();
        $stmt->close();
        require_once 'view/index.php';
    }

    // Hiển thị form thêm mới
    public function create() {
        $stmt = $this->nganh_hoc->getAll();
        $stmt->store_result();
        $meta = $stmt->result_metadata();
        $fields = [];
        $row = [];
        while ($field = $meta->fetch_field()) {
            $fields[] = &$row[$field->name];
        }
        call_user_func_array([$stmt, 'bind_result'], $fields);
        
        $nganh_hoc_list = [];
        while ($stmt->fetch()) {
            $temp = [];
            foreach ($row as $key => $val) {
                $temp[$key] = $val;
            }
            $nganh_hoc_list[] = $temp;
        }
        $stmt->free_result();
        $stmt->close();
        require_once 'view/create.php';
    }

    // Lưu sinh viên mới
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->student->MaSV = $_POST['MaSV'];
            $this->student->HoTen = $_POST['HoTen'];
            $this->student->GioiTinh = $_POST['GioiTinh'];
            $this->student->NgaySinh = $_POST['NgaySinh'];
            $this->student->MaNganh = $_POST['MaNganh'];

            // Xử lý upload ảnh
            if (isset($_FILES['Hinh']) && $_FILES['Hinh']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = 'uploads/';
                if (!file_exists($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }

                // Lấy phần mở rộng của file
                $fileExtension = strtolower(pathinfo($_FILES['Hinh']['name'], PATHINFO_EXTENSION));
                
                // Kiểm tra xem có phải là file ảnh không
                $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
                if (!in_array($fileExtension, $allowedTypes)) {
                    die("Lỗi: Chỉ chấp nhận file ảnh có định dạng: " . implode(', ', $allowedTypes));
                }

                // Tạo tên file mới
                $fileName = uniqid() . '.' . $fileExtension;
                $uploadFile = $uploadDir . $fileName;

                if (move_uploaded_file($_FILES['Hinh']['tmp_name'], $uploadFile)) {
                    $this->student->Hinh = $fileName;
                } else {
                    die("Lỗi: Không thể upload file ảnh.");
                }
            }

            if ($this->student->create()) {
                header('Location: index.php');
            } else {
                echo "Lỗi: Không thể thêm sinh viên mới.";
            }
        }
    }

    // Hiển thị chi tiết sinh viên
    public function detail() {
        if (isset($_GET['id'])) {
            $this->student->MaSV = $_GET['id'];
            if ($this->student->getOne()) {
                $student = [
                    'MaSV' => $this->student->MaSV,
                    'HoTen' => $this->student->HoTen,
                    'GioiTinh' => $this->student->GioiTinh,
                    'NgaySinh' => $this->student->NgaySinh,
                    'Hinh' => $this->student->Hinh,
                    'MaNganh' => $this->student->MaNganh,
                    'TenNganh' => $this->student->TenNganh
                ];
                require_once 'view/detail.php';
            }
        }
    }

    // Hiển thị form sửa
    public function edit() {
        if (isset($_GET['id'])) {
            $this->student->MaSV = $_GET['id'];
            if ($this->student->getOne()) {
                $student = [
                    'MaSV' => $this->student->MaSV,
                    'HoTen' => $this->student->HoTen,
                    'GioiTinh' => $this->student->GioiTinh,
                    'NgaySinh' => $this->student->NgaySinh,
                    'Hinh' => $this->student->Hinh,
                    'MaNganh' => $this->student->MaNganh
                ];

                $stmt = $this->nganh_hoc->getAll();
                $result = $stmt->get_result();
                $nganh_hoc_list = [];
                while ($row = $result->fetch_assoc()) {
                    $nganh_hoc_list[] = $row;
                }
                $stmt->close();
                require_once 'view/edit.php';
            }
        }
    }

    // Cập nhật sinh viên
    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->student->MaSV = $_POST['MaSV'];
            $this->student->HoTen = $_POST['HoTen'];
            $this->student->GioiTinh = $_POST['GioiTinh'];
            $this->student->NgaySinh = $_POST['NgaySinh'];
            $this->student->MaNganh = $_POST['MaNganh'];

            // Lấy thông tin ảnh cũ
            $old_image = null;
            if ($this->student->getOne()) {
                $old_image = $this->student->Hinh;
            }

            // Xử lý upload ảnh
            if (isset($_FILES['Hinh']) && $_FILES['Hinh']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = 'uploads/';
                if (!file_exists($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }

                // Lấy phần mở rộng của file
                $fileExtension = strtolower(pathinfo($_FILES['Hinh']['name'], PATHINFO_EXTENSION));
                
                // Kiểm tra xem có phải là file ảnh không
                $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
                if (!in_array($fileExtension, $allowedTypes)) {
                    die("Lỗi: Chỉ chấp nhận file ảnh có định dạng: " . implode(', ', $allowedTypes));
                }

                // Tạo tên file mới
                $fileName = uniqid() . '.' . $fileExtension;
                $uploadFile = $uploadDir . $fileName;

                if (move_uploaded_file($_FILES['Hinh']['tmp_name'], $uploadFile)) {
                    // Xóa ảnh cũ nếu có
                    if ($old_image && file_exists('uploads/' . $old_image)) {
                        unlink('uploads/' . $old_image);
                    }
                    $this->student->Hinh = $fileName;
                } else {
                    die("Lỗi: Không thể upload file ảnh.");
                }
            } else {
                // Giữ nguyên ảnh cũ nếu không upload ảnh mới
                $this->student->Hinh = $old_image;
            }

            if ($this->student->update()) {
                header('Location: index.php');
            } else {
                echo "Lỗi: Không thể cập nhật thông tin sinh viên.";
            }
        }
    }

    // Xóa sinh viên
    public function delete() {
        if (isset($_GET['id'])) {
            $this->student->MaSV = $_GET['id'];
            
            // Xóa file ảnh nếu có
            if ($this->student->getOne() && $this->student->Hinh) {
                $image_path = 'uploads/' . $this->student->Hinh;
                if (file_exists($image_path)) {
                    unlink($image_path);
                }
            }

            if ($this->student->delete()) {
                header('Location: index.php');
            } else {
                echo "Lỗi: Không thể xóa sinh viên.";
            }
        }
    }
}
?>
