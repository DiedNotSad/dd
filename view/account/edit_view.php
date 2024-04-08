<?php
if (!defined('APP_ROOT_PATH')) {
    die('Can not access');
}

$namePage = 'edit Account';
$errorAdd = $_SESSION['error_account'] ?? null;
?>
<!-- load header view -->
<?php require APP_PATH_VIEW . "partials/header_view.php"; ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">edit Account</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="index.php?c=account">Account</a></li>
                        <li class="breadcrumb-item active">Form edit</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12 col-md-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h5 class="card-title">
                                update Account
                            </h5>
                        </div>
                        <div class="card-body">
                            <form method="post" action="index.php?c=account&m=handle-update&id=<?= $infoDetail['id']; ?>">
                                <div class="row">
                                    <div class="col-sm-12 col-md-6">
                                        <div class="form-group mb-3">
                                            <label>Username</label>
                                            <input type="text" class="form-control" name="username" />
                                            <?php if(!empty($errorAdd['username'])): ?>
                                                <span class="text-danger"><?= $errorAdd['username'] ?></span>
                                            <?php endif; ?>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label>Password</label>
                                            <input type="password" class="form-control" name="password" />
                                            <?php if(!empty($errorAdd['password'])): ?>
                                                <span class="text-danger"><?= $errorAdd['password'] ?></span>
                                            <?php endif; ?>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label>Role ID</label>
                                            <select class="form-control" name="role_id">
                                                <?php
                                                    // Thực hiện kết nối đến cơ sở dữ liệu bằng PDO
                                                    try {
                                                        $conn = connectionDb();
                                                        // Thiết lập chế độ báo lỗi cho PDO
                                                        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                                                        // Truy vấn cơ sở dữ liệu để lấy dữ liệu từ bảng departments
                                                        $sql = "SELECT `id`, `name` FROM `roles`";
                                                        $stmt = $conn->prepare($sql);
                                                        $stmt->execute();

                                                        // Kiểm tra xem có dữ liệu trả về không
                                                        if ($stmt->rowCount() > 0) {
                                                            // Duyệt qua từng hàng dữ liệu và tạo option cho combobox
                                                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                                                echo "<option value='" . $row["id"] . "'>" . $row["name"] . "</option>";
                                                            }
                                                        } else {
                                                            echo "<option value=''>No roles found</option>";
                                                        }
                                                    } catch(PDOException $e) {
                                                        echo "<option value=''>Error retrieving data: " . $e->getMessage() . "</option>";
                                                    } finally {
                                                        // Đóng kết nối
                                                        $conn = null;
                                                    }
                                                ?>
                                            </select>  
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <div class="form-group mb-3">
                                            <label>User ID</label>
                                            <select class="form-control" name="users_id">
                                            <?php
                                                    // Thực hiện kết nối đến cơ sở dữ liệu bằng PDO
                                                    try {
                                                        $conn = connectionDb();
                                                        // Thiết lập chế độ báo lỗi cho PDO
                                                        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                                                        // Truy vấn cơ sở dữ liệu để lấy dữ liệu từ bảng departments
                                                        $sql = "SELECT `id`, `extra_code` FROM `users`";
                                                        $stmt = $conn->prepare($sql);
                                                        $stmt->execute();

                                                        // Kiểm tra xem có dữ liệu trả về không
                                                        if ($stmt->rowCount() > 0) {
                                                            // Duyệt qua từng hàng dữ liệu và tạo option cho combobox
                                                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                                                echo "<option value='" . $row["id"] . "'>" . $row["extra_code"] . "</option>";
                                                            }
                                                        } else {
                                                            echo "<option value=''>No User found</option>";
                                                        }
                                                    } catch(PDOException $e) {
                                                        echo "<option value=''>Error retrieving data: " . $e->getMessage() . "</option>";
                                                    } finally {
                                                        // Đóng kết nối
                                                        $conn = null;
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label>IP Client</label>
                                            <input type="text" class="form-control" name="ip_client" />
                                        </div>
                                        <div class="form-group mb-3">
                                            <label>Status</label>
                                            <select class="form-control" name="status">
                                                <option value="1">Active</option>
                                                <option value="0">Deactive</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-md-6">
                                        <button class="btn btn-primary btn-lg" type="submit" name="btnUpdate">UPdate</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<!-- load footer view -->
<?php require APP_PATH_VIEW . "partials/footer_view.php"; ?>
