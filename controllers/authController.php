<?php
require_once 'config/db.php';
require_once 'models/User.php';

class AuthController {
    private $user;

    public function __construct() {
        global $conn;
        $this->user = new User($conn);
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $password = '';

            if ($this->user->login($username, $password)) {
                $_SESSION['MaSV'] = $username;
                header('Location: index.php');
                exit;
            } else {
                $error = "Mã sinh viên không tồn tại trong hệ thống";
                require_once 'view/auth/login.php';
            }
        } else {
            require_once 'view/auth/login.php';
        }
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->user->MaSV = $_POST['MaSV'];
            $this->user->HoTen = $_POST['HoTen'];
            $this->user->Password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $this->user->Email = $_POST['email'];

            if ($this->user->create()) {
                $_SESSION['success'] = "Đăng ký thành công! Vui lòng đăng nhập.";
                header('Location: login.php');
                exit;
            } else {
                $error = "Có lỗi xảy ra khi đăng ký";
                require_once 'view/auth/register.php';
            }
        } else {
            require_once 'view/auth/register.php';
        }
    }

    public function logout() {
        session_destroy();
        header('Location: login.php');
        exit;
    }
}
?>
