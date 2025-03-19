<?php include_once 'layout/header.php'; ?>

<div class="container mt-4">
    <h2>CHI TIẾT SINH VIÊN</h2>
    
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <?php if($student['Hinh'] && file_exists('uploads/' . $student['Hinh'])): ?>
                        <img src="uploads/<?php echo htmlspecialchars($student['Hinh']); ?>" 
                             alt="Ảnh sinh viên" 
                             class="img-fluid rounded" 
                             style="max-width: 100%; height: auto; border: 1px solid #ddd; padding: 5px;">
                    <?php else: ?>
                        <div class="alert alert-info">Không có ảnh</div>
                    <?php endif; ?>
                </div>
                <div class="col-md-8">
                    <table class="table">
                        <tr>
                            <th style="width: 30%">MSSV:</th>
                            <td><?php echo htmlspecialchars($student['MaSV']); ?></td>
                        </tr>
                        <tr>
                            <th>Họ tên:</th>
                            <td><?php echo htmlspecialchars($student['HoTen']); ?></td>
                        </tr>
                        <tr>
                            <th>Giới tính:</th>
                            <td><?php echo htmlspecialchars($student['GioiTinh']); ?></td>
                        </tr>
                        <tr>
                            <th>Ngày sinh:</th>
                            <td><?php echo date('d/m/Y', strtotime($student['NgaySinh'])); ?></td>
                        </tr>
                        <tr>
                            <th>Ngành học:</th>
                            <td><?php echo htmlspecialchars($student['TenNganh']); ?></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-3">
        <a href="index.php" class="btn btn-secondary">Quay lại</a>
        <a href="index.php?action=edit&id=<?php echo urlencode($student['MaSV']); ?>" class="btn btn-primary">Sửa</a>
        <a href="index.php?action=delete&id=<?php echo urlencode($student['MaSV']); ?>" class="btn btn-danger" onclick="return confirm('Bạn có chắc muốn xóa sinh viên này?')">Xóa</a>
    </div>
</div>

<?php include_once 'layout/footer.php'; ?>
