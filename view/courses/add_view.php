<?php
if (!defined('APP_ROOT_PATH')) {
    die('Can not access');
}

$namePage = 'Create Course';
$errorAdd = $_SESSION['error_course'] ?? null;
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
                    <h1 class="m-0">Create Course</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="index.php?c=course">Courses</a></li>
                        <li class="breadcrumb-item active">Form Add new</li>
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
                    <div class="card card-primary">Enter name, please
                        <div class="card-header">
                            <h5 class="card-title">
                                Create Course
                            </h5>
                        </div>
                        <div class="card-body">
                            <form enctype="multipart/form-data" method="post" action="index.php?c=course&m=handle-add">
                                <div class="row">
                                    <div class="col-sm-12 col-md-6">
                                        <div class="form-group mb-3">
                                            <label>Name</label>
                                            <input type="text" class="form-control" name="name" />
                                            <?php if(!empty($errorAdd['name'])): ?>
                                                <span class="text-danger"><?= $errorAdd['name'] ?></span>
                                            <?php endif; ?>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label>Description</label>
                                            <input class="form-control" name="description"></input>
                                            <?php if(!empty($errorAdd['description'])): ?>
                                                <span class="text-danger"><?= $errorAdd['description'] ?></span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <div class="form-group mb-3">
                                            <label >Department</label>
                                            <select class="form-control" name="department_id">
                                            <?php
// Thực hiện kết nối đến cơ sở dữ liệu bằng PDO
try {
    $conn = connectionDb();
    // Thiết lập chế độ báo lỗi cho PDO
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Truy vấn cơ sở dữ liệu để lấy dữ liệu từ bảng departments
    $sql = "SELECT `id`, `name` FROM `departments` WHERE `deleted_at` IS NULL";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    // Kiểm tra xem có dữ liệu trả về không
    if ($stmt->rowCount() > 0) {
        // Duyệt qua từng hàng dữ liệu và tạo option cho combobox
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<option value='" . $row["id"] . "'>" . $row["name"] . "</option>";
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
                                                <option value="1">Active</option>
                                                <option value="0">Deactive</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-md-6">
                                        <button class="btn btn-primary btn-lg" type="submit" name="btnSaveCourse"> Save </button>
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