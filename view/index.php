<?php include_once 'layout/header.php'; ?>

<div class="container mt-4">
    <h2>DANH SÁCH SINH VIÊN</h2>
    <a href="index.php?action=create" class="btn btn-success mb-3">Thêm sinh viên mới</a>
    
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>MSSV</th>
                <th>Họ tên</th>
                <th>Giới tính</th>
                <th>Ngày sinh</th>
                <th>Ngành học</th>
                <th>Ảnh</th>
                <th>Thao tác</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($students as $student): ?>
            <tr>
                <td><?php echo $student['MaSV']; ?></td>
                <td><?php echo $student['HoTen']; ?></td>
                <td><?php echo $student['GioiTinh']; ?></td>
                <td><?php echo date('d/m/Y', strtotime($student['NgaySinh'])); ?></td>
                <td><?php echo $student['TenNganh']; ?></td>
                <td>
                    <?php if($student['Hinh']): ?>
                        <img src="<?php echo $student['Hinh']; ?>" alt="Ảnh sinh viên" style="max-width: 100px;">
                    <?php endif; ?>
                </td>
                <td>
                    <a href="index.php?action=detail&id=<?php echo $student['MaSV']; ?>" class="btn btn-info btn-sm">Chi tiết</a>
                    <a href="index.php?action=edit&id=<?php echo $student['MaSV']; ?>" class="btn btn-primary btn-sm">Sửa</a>
                    <a href="index.php?action=delete&id=<?php echo $student['MaSV']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc muốn xóa sinh viên này?')">Xóa</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include_once 'layout/footer.php'; ?>
