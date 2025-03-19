<?php include_once 'view/layout/header.php'; ?>

<div class="container mt-4">
    <h2>DANH SÁCH NGÀNH HỌC</h2>
    <a href="nganh_hoc.php?action=create" class="btn btn-success mb-3">Thêm ngành học mới</a>
    
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Mã ngành</th>
                <th>Tên ngành</th>
                <th>Thao tác</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($nganh_hoc_list as $nganh): ?>
            <tr>
                <td><?php echo $nganh['MaNganh']; ?></td>
                <td><?php echo $nganh['TenNganh']; ?></td>
                <td>
                    <a href="nganh_hoc.php?action=edit&id=<?php echo $nganh['MaNganh']; ?>" class="btn btn-primary btn-sm">Sửa</a>
                    <a href="nganh_hoc.php?action=delete&id=<?php echo $nganh['MaNganh']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc muốn xóa ngành học này?')">Xóa</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="mt-3">
        <a href="index.php" class="btn btn-secondary">Quay lại trang sinh viên</a>
    </div>
</div>

<?php include_once 'view/layout/footer.php'; ?> 