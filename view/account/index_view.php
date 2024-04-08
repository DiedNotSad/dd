<?php
if (!defined('APP_ROOT_PATH')) {
    die('Can not access');
}
$namePage = 'Account';
$state = trim($_GET['state'] ?? null);
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
                    <h1 class="m-0">Account</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="index.php?c=dashboard">Home</a></li>
                        <li class="breadcrumb-item active">List view</li>
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
                    <a class="btn btn-primary" href="index.php?c=account&m=add"> Create new Account</a>
                    <div class="row">
                        <div class="col-sm-12 col-md-6">
                            <div class="form-group my-3">
                                <input
                                    id="keywordAccount"
                                    type="text" name="search"
                                    value="<?= htmlentities($keyword); ?>"
                                />
                                <button
                                    id="btnSearchAccount"
                                    type="button"
                                    class="btn btn-primary btn-sm mb-0"
                                > Search</button>
                                <a class="btn btn-info btn-sm" href="index.php?c=account"> Back to list</a>
                            </div>
                        </div>
                    </div>
                    <?php if($state === 'delete_success'): ?>
                        <div class="my-3 text-success">
                            Delete account Successfully !
                        </div>
                    <?php elseif( $state === 'delete_failure'): ?>
                        <div class="my-3 text-danger">
                            Delete account Failure !
                        </div>
                    <?php endif; ?>

                    <?php if( $state === 'success'): ?>
                        <div class="my-3 text-success text-center">
                            Action Successfully !
                        </div>
                    <?php endif; ?>

                    <table class="mt-3 table table-bordered table-striped">
                        <thead class="table-primary">
                            <tr>
                                <th>ID</th>
                                <th>Role ID</th>
                                <th>Username</th>
                                <th>Password</th>
                                <th>Ip client</th>
                                <th>Status</th>
                                <th width="10%" class="text-center" colspan="2">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($accounts as $key => $item): ?>
                                <tr>
                                    <td><?= $item['id']; ?></td>
                                    <td><?= $item['role_id'] ?></td>
                                    <td><?= $item['username']; ?></td>
                                    <td><?= $item['password']; ?></td>
                                    <td><?= $item['ip_client']; ?></td>
                                    <td><?= $item['status'] == 1 ? 'Active' : 'Deactive'; ?></td>
                                    <td>
                                        <a class="btn btn-info btn-sm" href="index.php?c=account&m=edit&id=<?= $item['id'];?>"> Edit</a>
                                    </td>
                                    <td>
                                        <a class="btn btn-danger btn-sm" href="index.php?c=account&m=delete&id=<?= $item['id'];?>"> Delete</a>
                                    </td>
                                </tr>

                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <!-- phan trang -->
                    <?=$htmlPage; ?>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<!-- load footer view -->
<?php require APP_PATH_VIEW . "partials/footer_view.php"; ?>
<script type="text/javascript">
    let btnSearch = document.getElementById('btnSearchAccount');
    btnSearch.addEventListener('click', function(){
        let keyword = document.getElementById('keywordAccount');
        let valueKeyword = keyword.value.trim();
        if(valueKeyword != ''){
            window.location.href = "index.php?c=account&search=" + valueKeyword;
        } else {
            alert("Enter keyword, please");
            return;
        }
    });
</script>
