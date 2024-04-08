<?php
if (!defined('APP_ROOT_PATH')) {
    die('Can not access');
}
$namePage = 'Update Course'; // Update page title
$errorAdd = $_SESSION['error_course'] ?? null; // Update error session variable name
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
                    <h1 class="m-0">Update Course</h1> <!-- Update page title -->
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="index.php?c=course">Courses</a></li> <!-- Update breadcrumb link -->
                        <li class="breadcrumb-item active">Form update Course</li>
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
                                Update Course <!-- Update card title -->
                            </h5>
                        </div>
                        <div class="card-body">
                            <form enctype="multipart/form-data" method="post" action="index.php?c=course&m=handle-update&id=<?= $infoDetail['id']; ?>"> <!-- Update form action URL -->
                                <div class="row">
                                    <div class="col-sm-12 col-md-6">
                                    <div class="form-group mb-3">
                                            <label>Name</label>
                                            <input type="text" class="form-control" name="name" value="<?= $infoDetail['name']; ?>" />
                                            <?php if(!empty($errorAdd['name'])): ?>
                                                <span class="text-danger"><?= $errorAdd['name'] ?></span>
                                            <?php endif; ?>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label>Description</label>
                                            <input type="text" class="form-control" name="description" value="<?= $infoDetail['description']; ?>" ></input>
                                            <?php if(!empty($errorAdd['description'])): ?>
                                                <span class="text-danger"><?= $errorAdd['description'] ?></span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <div class="form-group mb-3">
                                            <form action="#" method="post">
                                                <label for="department_id">Department:</label>
                                                <select name="department_id" id="department_id">
    <?php
    // Thực hiện kết nối đến cơ sở dữ liệu bằng PDO
    try {
        $conn = connectionDb();
        // Thiết lập chế độ báo lỗi cho PDO
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Truy vấn cơ sở dữ liệu để lấy dữ liệu từ bảng departments
        $sql = "SELECT id, name FROM departments WHERE `deleted_at` IS NULL ";
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        // Kiểm tra xem có dữ liệu trả về không
        if ($stmt->rowCount() > 0) {
            // Duyệt qua từng hàng dữ liệu và tạo option cho combobox
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $selected = ($row['id'] == $infoDetail['department_id']) ? 'selected' : ''; // Kiểm tra xem giá trị của biến $infoDetail['department_id'] có trùng với id của phòng ban không
                echo "<option value='" . $row["id"] . "' $selected>" . $row["name"] . "</option>";
            }
        } else {
            echo "<option value=''>No departments found</option>";
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
                                            <label>Status</label>
                                            <select class="form-control" name="status">
                                                <option
                                                    value="1"
                                                    <?= $infoDetail['status'] == 1 ? 'selected' : null; ?>
                                                >Active</option>
                                                <option
                                                    value="0"
                                                    <?= $infoDetail['status'] == 0 ? 'selected' : null; ?>
                                                >Deactive</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-md-6">
                                        <button class="btn btn-primary btn-lg" type="submit" name="btnUpdate"> Update </button>
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
