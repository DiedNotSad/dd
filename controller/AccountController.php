<?php
require 'model/AccountModel.php';

$m = trim($_GET['m'] ?? 'index'); // trim : xoa khoang trang 2 dau
$m = strtolower($m); // chuyen ve chu thuong
switch ($m) {
    case 'index':
        index();
        break;
    case 'add':
        Add();
        break;
    case 'handle-add':
        handleAdd();
        break;
    case 'delete':
        handleDelete();
        break;
    case 'edit':
        edit();
        break;
    case 'handle-update':
        handleUpdate();
        break;
    default:
        index();
        break;
}

function handleUpdate()
{
    if (isset($_POST['btnUpdate'])) {
        $id = $_GET['id'] ?? null;
        $id = is_numeric($id) ? $id : 0;

        $roleId = trim($_POST['role_id'] ?? null);
        $roleId = is_numeric($roleId) ? $roleId : 0;

        $userId = trim($_POST['user_id'] ?? null);
        $userId = is_numeric($userId) ? $userId : 0;

        $username = trim($_POST['username'] ?? null);
        $username = strip_tags($username);

        $password = trim($_POST['password'] ?? null);
        $password = strip_tags($password);

        $ipClient = trim($_POST['ip_client'] ?? null);
        $ipClient = strip_tags($ipClient);

        $lastLogin = trim($_POST['last_login'] ?? null);
        $lastLogin = date('Y-m-d H:i:s', strtotime($lastLogin));

        $lastLogout = trim($_POST['last_logout'] ?? null);
        $lastLogout = date('Y-m-d H:i:s', strtotime($lastLogout));

        $status = trim($_POST['status'] ?? null);
        $status = $status === '0' || $status === '1' ? $status : 0;

        $updatedAt = date('Y-m-d H:i:s');

        $info = getDetailAccountById($id);

        // check du lieu
        $_SESSION['error_account'] = [];

        if (empty($username)) {
            $_SESSION['error_account']['username'] = 'Enter username, please';
        } else {
            $_SESSION['error_account']['username'] = null;
        }

        if (empty($password)) {
            $_SESSION['error_account']['password'] = 'Enter password, please';
        } else {
            $_SESSION['error_account']['password'] = null;
        }

        $checkError = false;
        foreach ($_SESSION['error_account'] as $error) {
            if (!empty($error)) {
                $checkError = true;
                break;
            }
        }

        if ($checkError) {
            // co loi xay ra
            // quay lai form update
            header("Location:index.php?c=account&m=edit&id={$id}");
        } else {
            // khong co loi gi ca
            // tien hanh update vao database
            if (isset($_SESSION['error_account'])) {
                unset($_SESSION['error_account']);
            }
            $update = updateAccountById(
                $roleId,
                $userId,
                $username,
                $password,
                $ipClient,
                $status,
                $id
            );

            if ($update) {
                // thanh cong
                header("Location:index.php?c=account&state=success");
            } else {
                // that bai
                header("Location:index.php?c=account&m=edit&id={$id}&state=failure");
            }
        }
    }
}

function edit()
{
    $id = trim($_GET['id'] ?? null);
    $id = is_numeric($id) ? $id : 0; // is_numeric : kiem tra gia tri co phai la so hay ko?
    $infoDetail = getDetailAccountById($id);

    if (!empty($infoDetail)) {
        // co du lieu trong database
        // hien thi thong tin du lieu
        require APP_PATH_VIEW . 'account/edit_view.php';
    } else {
        // khong co du lieu
        // thong bao loi
        require APP_PATH_VIEW . 'error_view.php';
    }
}

function handleDelete()
{
    $id = trim($_GET['id'] ?? null);
    $delete = deleteAccountById($id);

    if ($delete) {
        header("Location:index.php?c=account&state=delete_success");
    } else {
        header("Location:index.php?c=account&state=delete_failure");
    }
}

function handleAdd()
{
    if (isset($_POST['btnSave'])) {
        $roleId = trim($_POST['role_id'] ?? null);
        $roleId = is_numeric($roleId) ? $roleId : 0;

        $userId = trim($_POST['user_id'] ?? null);
        $userId = is_numeric($userId) ? $userId : 0;

        $username = trim($_POST['username'] ?? null);
        $username = strip_tags($username);

        $password = trim($_POST['password'] ?? null);
        $password = strip_tags($password);

        $ipClient = trim($_POST['ip_client'] ?? null);
        $ipClient = strip_tags($ipClient);

        $lastLogin = trim($_POST['last_login'] ?? null);
        $lastLogin = date('Y-m-d H:i:s', strtotime($lastLogin));

        $lastLogout = trim($_POST['last_logout'] ?? null);
        $lastLogout = date('Y-m-d H:i:s', strtotime($lastLogout));

        $status = trim($_POST['status'] ?? null);
        $status = $status === '0' || $status === '1' ? $status : 0;

        $createdAt = date('Y-m-d H:i:s');

        // check du lieu
        $_SESSION['error_account'] = [];

        if (empty($username)) {
            $_SESSION['error_account']['username'] = 'Enter username, please';
        } else {
            $_SESSION['error_account']['username'] = null;
        }

        if (empty($password)) {
            $_SESSION['error_account']['password'] = 'Enter password, please';
        } else {
            $_SESSION['error_account']['password'] = null;
        }

        if (
            !empty($_SESSION['error_account']['username'])
            ||
            !empty($_SESSION['error_account']['password'])
        ) {
            // co loi - thong bao ve lai form add
            header("Location:index.php?c=account&m=add&state=fail");
        } else {
            // insert vao database
            if (isset($_SESSION['error_account'])) {
                unset($_SESSION['error_account']);
            }

            $insert = insertAccount(
                $roleId,
                $userId,
                $username,
                $password,
                $ipClient,
                $status
            );

            if ($insert) {
                header("Location:index.php?c=account&state=success");
            } else {
                header("Location:index.php?c=account&m=add&state=error");
            }
        }
    }
}

function Add()
{
    require APP_PATH_VIEW . 'account/add_view.php';
}

function index()
{
    $keyword = trim($_GET['search'] ?? null);
    $keyword = strip_tags($keyword);

    $page = trim($_GET['page'] ?? null);
    $page = (is_numeric($page) && $page > 0) ? $page : 1;

    $linkPage = createlink([
        'c' => 'account',
        'm' => 'index',
        'page' => '{page}',
        'search' => $keyword
    ]);

    $itemAccounts = getAllDataAccounts($keyword);
    $itemAccounts = count($itemAccounts);

    $pagination = pagination($linkPage, $itemAccounts, $page, LIMIT_ITEM_PAGE);
    $start = $pagination['start'] ?? 0;
    $accounts = getAllDataAccountsByMyPage($keyword, $start, LIMIT_ITEM_PAGE);
    $htmlPage = $pagination['htmlPage'] ?? null;

    require APP_PATH_VIEW . 'account/index_view.php';
}
