<?php include_once 'view/layout/header.php'; ?>

<div class="container mt-4">
    <h2 class="mb-4">ĐĂNG KÝ HỌC PHẦN</h2>
    
    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success">
            <?php 
                echo $_SESSION['success'];
                unset($_SESSION['success']);
            ?>
        </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger">
            <?php 
                echo $_SESSION['error'];
                unset($_SESSION['error']);
            ?>
        </div>
    <?php endif; ?>
    
    <?php if (empty($registered_courses)): ?>
        <div class="alert alert-info">
            Bạn chưa đăng ký học phần nào.
        </div>
    <?php else: ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Mã HP</th>
                    <th>Tên học phần</th>
                    <th>Số tín chỉ</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($registered_courses as $course): ?>
                <tr>
                    <td><?php echo htmlspecialchars($course['MaHP']); ?></td>
                    <td><?php echo htmlspecialchars($course['TenHP']); ?></td>
                    <td><?php echo htmlspecialchars($course['SoTC']); ?></td>
                    <td>
                        <form action="hoc_phan.php?action=unregister" method="POST" style="display: inline;">
                            <input type="hidden" name="MaHP" value="<?php echo $course['MaHP']; ?>">
                            <button type="submit" class="btn btn-danger">
                                Hủy
                            </button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div class="mt-4">
            <a href="hoc_phan.php?action=unregister_all" class="btn btn-danger" 
               onclick="return confirm('Bạn có chắc chắn muốn xóa tất cả các học phần đã đăng ký?');">
                Xóa đăng ký (xóa hết các học phần)
            </a>
        </div>
    <?php endif; ?>

    <div class="mt-3">
        <a href="hoc_phan.php" class="btn btn-secondary">
            Quay lại
        </a>
    </div>
</div>

<?php include_once 'view/layout/footer.php'; ?> 