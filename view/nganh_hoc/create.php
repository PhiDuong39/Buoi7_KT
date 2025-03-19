<?php include_once 'view/layout/header.php'; ?>

<div class="container mt-4">
    <h2>THÊM NGÀNH HỌC MỚI</h2>
    
    <form action="nganh_hoc.php?action=store" method="POST">
        <div class="form-group">
            <label>Mã ngành:</label>
            <input type="text" name="MaNganh" class="form-control" required maxlength="4">
            <small class="form-text text-muted">Mã ngành tối đa 4 ký tự</small>
        </div>

        <div class="form-group">
            <label>Tên ngành:</label>
            <input type="text" name="TenNganh" class="form-control" required maxlength="30">
        </div>

        <button type="submit" class="btn btn-primary mt-3">Lưu</button>
        <a href="nganh_hoc.php" class="btn btn-secondary mt-3">Quay lại</a>
    </form>
</div>

<?php include_once 'view/layout/footer.php'; ?> 