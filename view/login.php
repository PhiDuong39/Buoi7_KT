<?php
include("../config/db.php");
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $MaSV = $_POST["MaSV"];
    $MatKhau = $_POST["MatKhau"];

    $sql = "SELECT * FROM TaiKhoan WHERE MaSV='$MaSV' AND MatKhau='$MatKhau'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $_SESSION["MaSV"] = $MaSV;
        header("Location: index.php");
    } else {
        echo "Sai thông tin đăng nhập!";
    }
}
?>
<form method="POST">
    Mã SV: <input type="text" name="MaSV"><br>
    Mật khẩu: <input type="password" name="MatKhau"><br>
    <input type="submit" value="Đăng nhập">
</form>
