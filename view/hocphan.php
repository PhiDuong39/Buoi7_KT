<?php
include("../config/db.php");
$sql = "SELECT * FROM HocPhan";
$result = $conn->query($sql);
?>
<h2>Danh sách Học Phần</h2>
<table border="1">
    <tr>
        <th>Mã HP</th>
        <th>Tên HP</th>
        <th>Số tín chỉ</th>
        <th>Đăng ký</th>
    </tr>
    <?php while ($row = $result->fetch_assoc()) { ?>
        <tr>
            <td><?= $row['MaHP'] ?></td>
            <td><?= $row['TenHP'] ?></td>
            <td><?= $row['SoTinChi'] ?></td>
            <td><a href="cart.php?MaHP=<?= $row['MaHP'] ?>">Đăng ký</a></td>
        </tr>
    <?php } ?>
</table>
