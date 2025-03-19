<?php include_once 'view/layout/header.php'; ?>

<div class="container mt-4">
    <h2>DANH SÁCH HỌC PHẦN</h2>
    <table class="table table-bordered table-hover">
        <thead class="table-light">
            <tr>
                <th>Mã HP</th>
                <th>Tên học phần</th>
                <th>Số tín chỉ</th>
                <th style="width: 150px;">Thao tác</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($hoc_phan_list as $hp): ?>
            <tr>
                <td><?php echo htmlspecialchars($hp['MaHP']); ?></td>
                <td><?php echo htmlspecialchars($hp['TenHP']); ?></td>
                <td><?php echo isset($hp['SoTinChi']) ? htmlspecialchars($hp['SoTinChi']) : ''; ?></td>
                <td class="text-center">
                    <form action="hoc_phan.php?action=register" method="POST" class="d-inline">
                        <input type="hidden" name="MaHP" value="<?php echo $hp['MaHP']; ?>">
                        <button type="submit" class="btn btn-primary" 
                                onclick="return confirm('Bạn có chắc chắn muốn đăng ký học phần này?');">
                            <i class="fas fa-plus-circle"></i> Đăng ký
                        </button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <?php if (isset($_SESSION['MaSV'])): ?>
    <div class="mt-3">
        <a href="hoc_phan.php?action=myCourses" class="btn btn-info">
            <i class="fas fa-list"></i> Xem học phần đã đăng ký
        </a>
    </div>
    <?php endif; ?>

    <div class="mt-3">
        <a href="index.php" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Quay lại
        </a>
    </div>
</div>

<?php include_once 'view/layout/footer.php'; ?> 