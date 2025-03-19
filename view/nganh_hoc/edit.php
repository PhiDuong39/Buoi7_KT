<?php include_once 'view/layout/header.php'; ?>

<div class="container mt-4">
    <h2>SỬA NGÀNH HỌC</h2>
    
    <form action="nganh_hoc.php?action=update" method="POST">
        <input type="hidden" name="MaNganh" value="<?php echo $this->nganh_hoc->MaNganh; ?>">
        
        <div class="form-group">
            <label>Mã ngành:</label>
            <input type="text" class="form-control" value="<?php echo $this->nganh_hoc->MaNganh; ?>" disabled>
        </div>

        <div class="form-group">
            <label>Tên ngành:</label>
            <input type="text" name="TenNganh" class="form-control" value="<?php echo $this->nganh_hoc->TenNganh; ?>" required maxlength="30">
        </div>

        <button type="submit" class="btn btn-primary mt-3">Cập nhật</button>
        <a href="nganh_hoc.php" class="btn btn-secondary mt-3">Quay lại</a>
    </form>
</div>

<?php include_once 'view/layout/footer.php'; ?> 