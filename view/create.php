<?php include_once 'layout/header.php'; ?>

<div class="container mt-4">
    <h2>THÊM SINH VIÊN MỚI</h2>
    
    <form action="index.php?action=store" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label>Mã sinh viên:</label>
            <input type="text" name="MaSV" class="form-control" required maxlength="10">
        </div>

        <div class="form-group">
            <label>Họ tên:</label>
            <input type="text" name="HoTen" class="form-control" required maxlength="50">
        </div>

        <div class="form-group">
            <label>Giới tính:</label>
            <select name="GioiTinh" class="form-control" required>
                <option value="Nam">Nam</option>
                <option value="Nữ">Nữ</option>
            </select>
        </div>

        <div class="form-group">
            <label>Ngày sinh:</label>
            <input type="date" name="NgaySinh" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Ngành học:</label>
            <select name="MaNganh" class="form-control" required>
                <option value="">Chọn ngành học</option>
                <?php foreach($nganh_hoc_list as $nganh): ?>
                    <option value="<?php echo $nganh['MaNganh']; ?>">
                        <?php echo $nganh['TenNganh']; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label>Ảnh:</label>
            <input type="file" name="Hinh" class="form-control-file" accept="image/*">
        </div>

        <button type="submit" class="btn btn-primary mt-3">Lưu</button>
        <a href="index.php" class="btn btn-secondary mt-3">Quay lại</a>
    </form>
</div>

<?php include_once 'layout/footer.php'; ?>
