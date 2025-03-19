<?php include_once 'layout/header.php'; ?>

<div class="container mt-4">
    <h2>SỬA THÔNG TIN SINH VIÊN</h2>
    
    <form action="index.php?action=update" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="MaSV" value="<?php echo $student['MaSV']; ?>">
        
        <div class="form-group">
            <label>Mã sinh viên:</label>
            <input type="text" class="form-control" value="<?php echo $student['MaSV']; ?>" disabled>
        </div>

        <div class="form-group">
            <label>Họ tên:</label>
            <input type="text" name="HoTen" class="form-control" value="<?php echo $student['HoTen']; ?>" required maxlength="50">
        </div>

        <div class="form-group">
            <label>Giới tính:</label>
            <select name="GioiTinh" class="form-control" required>
                <option value="Nam" <?php echo ($student['GioiTinh'] == 'Nam') ? 'selected' : ''; ?>>Nam</option>
                <option value="Nữ" <?php echo ($student['GioiTinh'] == 'Nữ') ? 'selected' : ''; ?>>Nữ</option>
            </select>
        </div>

        <div class="form-group">
            <label>Ngày sinh:</label>
            <input type="date" name="NgaySinh" class="form-control" value="<?php echo $student['NgaySinh']; ?>" required>
        </div>

        <div class="form-group">
            <label>Ngành học:</label>
            <select name="MaNganh" class="form-control" required>
                <option value="">Chọn ngành học</option>
                <?php foreach($nganh_hoc_list as $nganh): ?>
                    <option value="<?php echo $nganh['MaNganh']; ?>" <?php echo ($student['MaNganh'] == $nganh['MaNganh']) ? 'selected' : ''; ?>>
                        <?php echo $nganh['TenNganh']; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label>Ảnh hiện tại:</label>
            <?php if($student['Hinh']): ?>
                <img src="uploads/<?php echo $student['Hinh']; ?>" alt="Ảnh sinh viên" style="max-width: 200px;">
            <?php else: ?>
                <div class="alert alert-info">Chưa có ảnh</div>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label>Thay đổi ảnh:</label>
            <input type="file" name="Hinh" class="form-control-file" accept="image/*">
        </div>

        <button type="submit" class="btn btn-primary mt-3">Cập nhật</button>
        <a href="index.php" class="btn btn-secondary mt-3">Quay lại</a>
    </form>
</div>

<?php include_once 'layout/footer.php'; ?>
