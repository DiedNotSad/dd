<?php
if (!defined('APP_ROOT_PATH')) {
    die('Can not access');
}

$namePage = 'Create User';
$errorAdd = $_SESSION['error_user'] ?? null;
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
                    <h1 class="m-0">Create User</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="index.php?c=user">User</a></li>
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
                    <div class="card card-primary">
                        <div class="card-header">
                            <h5 class="card-title">
                                Create User
                            </h5>
                        </div>
                        <div class="card-body">
                            <form enctype="multipart/form-data" method="post" action="index.php?c=user&m=handle-add">
                                <div class="row">
                                    <div class="col-sm-12 col-md-6">
                                        <div class="form-group mb-3">
                                            <label>Extra Code</label>
                                            <input type="text" class="form-control" name="extra_code" />
                                            <?php if(!empty($errorAdd['extra_code'])): ?>
                                                <span class="text-danger"><?= $errorAdd['extra_code'] ?></span>
                                            <?php endif; ?>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label>First Name</label>
                                            <input type="text" class="form-control" name="first_name" />
                                            <?php if(!empty($errorAdd['first_name'])): ?>
                                                <span class="text-danger"><?= $errorAdd['first_name'] ?></span>
                                            <?php endif; ?>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label>Last Name</label>
                                            <input type="text" class="form-control" name="last_name" />
                                            <?php if(!empty($errorAdd['last_name'])): ?>
                                                <span class="text-danger"><?= $errorAdd['last_name'] ?></span>
                                            <?php endif; ?>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label>Full Name</label>
                                            <input type="text" class="form-control" name="full_name" />
                                            <?php if(!empty($errorAdd['full_name'])): ?>
                                                <span class="text-danger"><?= $errorAdd['full_name'] ?></span>
                                            <?php endif; ?>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label>Email</label>
                                            <input type="email" class="form-control" name="email" />
                                            <?php if(!empty($errorAdd['email'])): ?>
                                                <span class="text-danger"><?= $errorAdd['email'] ?></span>
                                            <?php endif; ?>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label>Address</label>
                                            <input type="text" class="form-control" name="address" />
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <div class="form-group mb-3">
                                            <label>Phone</label>
                                            <input type="text" class="form-control" name="phone" />
                                            <?php if(!empty($errorAdd['phone'])): ?>
                                                <span class="text-danger"><?= $errorAdd['phone'] ?></span>
                                            <?php endif; ?>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label>Birthday</label>
                                            <input type="date" class="form-control" name="birthday" />
                                            <?php if(!empty($errorAdd['birthday'])): ?>
                                                <span class="text-danger"><?= $errorAdd['birthday'] ?></span>
                                            <?php endif; ?>
                                        </div>
                                        
                                        <div class="form-group mb-3">
                                            <label>Gender</label>
                                            <select class="form-control" name="gender">
                                                <option value="1">Nam</option>
                                                <option value="2">Nữ</option>
                                                <option value="3">Không xác định</option>
                                            </select>
                                            
                                        </div>
                                        <div class="form-group mb-3">
                                            <label> Avatar </label>
                                            <input type="file" class="form-control" name="avatar" />
                                            <?php if(!empty($errorAdd['avatar'])): ?>
                                                <span class="text-danger"><?= $errorAdd['avatar']; ?></span>
                                            <?php endif; ?>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label>Biography</label>
                                            <input type="text" class="form-control" name="biography" />
                                           
                                        </div>
                                        <div class="form-group mb-3">
                                            <label>Information</label>
                                            <input type="text" class="form-control" name="information" />
                                            
                                        </div>
                                       <div class="form-group mb-3">
                                            <label> Status </label>
                                            <select class="form-control" name="status">
                                                <option value="1">Active</option>
                                                <option value="0">Deactive</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-md-6">
                                        <button class="btn btn-primary btn-lg" type="submit" name="btnSave"> Save </button>
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
