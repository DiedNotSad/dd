<?php
require 'model/UserModel.php';

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
    if (isset($_POST['btnUpdateUser'])) {
        $id = $_GET['id'] ?? null;
        $id = is_numeric($id) ? $id : 0;

        $extraCode = trim($_POST['extra_code'] ?? null);
        $extraCode = strip_tags($extraCode);

        $firstName = trim($_POST['first_name'] ?? null);
        $firstName = strip_tags($firstName);

        $lastName = trim($_POST['last_name'] ?? null);
        $lastName = strip_tags($lastName);

        $fullName = trim($_POST['full_name'] ?? null);
        $fullName = strip_tags($fullName);

        $email = trim($_POST['email'] ?? null);
        $email = strip_tags($email);

        $phone = trim($_POST['phone'] ?? null);
        $phone = strip_tags($phone);

        $address = trim($_POST['address'] ?? null);
        $address = strip_tags($address);

        $birthday = trim($_POST['birthday'] ?? null);
        $birthday = date('Y-m-d', strtotime($birthday));

        $gender = trim($_POST['gender'] ?? null);
        $gender = ($gender == '1' || $gender == '2' || $gender == '3') ? $gender : '3';

        $avatar = ''; // Handle avatar upload if needed

        $biography = trim($_POST['biography'] ?? null);
        $biography = strip_tags($biography);

        $information = trim($_POST['information'] ?? null);
        $information = strip_tags($information);

        $status = trim($_POST['status'] ?? null);
        $status = ($status == '1' || $status == '0') ? $status : '0';


        
        $update = updateUser(
            $extraCode,
            $firstName,
            $lastName,
            $fullName,
            $email,
            $phone,
            $address,
            $birthday,
            $gender,
            $avatar,
            $biography,
            $information,
            $status,
            $id
        );

        if ($update) {
            // Success
            header("Location: index.php?c=user&state=success");
        } else {
            // Failure
            header("Location: index.php?c=user&m=edit&id={$id}&state=failure");
        }
    }
}

function edit()
{
    $id = trim($_GET['id'] ?? null);
    $id = is_numeric($id) ? $id : 0;
    $infoDetail = getUserById($id);

    if (!empty($infoDetail)) {
        // Render edit view with user info
        require APP_PATH_VIEW . 'users/edit_view.php';
    } else {
        // No user found
        require APP_PATH_VIEW . 'error_view.php';
    }
}

function handleDelete()
{
    $id = trim($_GET['id'] ?? null);
    $id = is_numeric($id) ? $id : 0;

    $delete = deleteUser($id);

    if ($delete) {
        header("Location: index.php?c=user&state=delete_success");
    } else {
        header("Location: index.php?c=user&state=delete_failure");
    }
}

function handleAdd()
{
    if (isset($_POST['btnSave'])) {
        $extraCode = trim($_POST['extra_code'] ?? null);
        $extraCode = strip_tags($extraCode);

        $firstName = trim($_POST['first_name'] ?? null);
        $firstName = strip_tags($firstName);

        $lastName = trim($_POST['last_name'] ?? null);
        $lastName = strip_tags($lastName);

        $fullName = trim($_POST['full_name'] ?? null);
        $fullName = strip_tags($fullName);

        $email = trim($_POST['email'] ?? null);
        $email = strip_tags($email);

        $phone = trim($_POST['phone'] ?? null);
        $phone = strip_tags($phone);

        $address = trim($_POST['address'] ?? null);
        $address = strip_tags($address);

        $birthday = trim($_POST['birthday'] ?? null);
        $birthday = date('Y-m-d', strtotime($birthday));

        $gender = trim($_POST['gender'] ?? null);
        $gender = ($gender == '1' || $gender == '2' || $gender == '3') ? $gender : '3';

        $avatar = null; // Handle avatar upload if needed

        $biography = trim($_POST['biography'] ?? null);
        $biography = strip_tags($biography);

        $information = trim($_POST['information'] ?? null);
        $information = strip_tags($information);

        $status = trim($_POST['status'] ?? null);
        $status = ($status == '1' || $status == '0') ? $status : '0';

        // Check dữ liệu
        $_SESSION['error_user'] = [];
        // Tiến hành upload avatar của người dùng
        $avatar = null;
        {
        // Người dùng muốn upload avatar
        $_SESSION['error_user']['avatar'] = null;
        if (!empty($_FILES['avatar']['tmp_name'])) {
            // thuc su nguoi dung muon upload logo
            $logo = uploadFile(
                $_FILES['avatar'],
                'public/uploads/images/',
                ['image/png', 'image/jpeg', 'image/jpg', 'image/svg'],
                3 * 1024 * 1024
            );
            if (empty($logo)) {
                $_SESSION['error_user']['avatar'] = 'Type file is allow .png, .jpg, .jpeg, .svg and size file <= 3Mb';
            } else {
                $_SESSION['error_user']['avatar'] = null;
            }
        }
        }
        if (empty($extraCode)) {
            $_SESSION['error_user']['extra_code'] = 'Enter extra_code';
        } else {
            $_SESSION['error_user']['extra_code'] = null;
        }
        if (empty($firstName)) {
            $_SESSION['error_user']['first_name'] = 'Enter first name';
        } else {
            $_SESSION['error_user']['first_name'] = null;
        }
        if (empty($lastName)) {
            $_SESSION['error_user']['last_name'] = "Enter last_name";
        } else {
            $_SESSION['error_user']['last_name'] = null;
        }
        if (empty($fullName)) {
            $_SESSION['error_user']['full_name'] = "Enter full name, ";
        } else {
            $_SESSION['error_user']['full_name'] = null;
        }
        if (empty($email)) {
            $_SESSION['error_user']['email'] = "Enter email, ";
        } else {
            $_SESSION['error_user']['email'] = null;
        }
        // Kiểm tra lỗi và xử lý
        if (
            !empty($_SESSION['error_user']['extra_code'])
            ||
            !empty($_SESSION['error_user']['first_name'])
            ||
            !empty($_SESSION['error_user']['last_name'])
            ||
            !empty($_SESSION['error_user']['full_name'])
            ||
            !empty($_SESSION['error_user']['email'])
            ||
            !empty($_SESSION['error_user']['avatar'])
           
        ) {
            // Có lỗi - thông báo trở lại form thêm
            header("Location:index.php?c=user&m=add&state=fail");
        } 
        else {
            // Insert vào cơ sở dữ liệu
            if (isset($_SESSION['error_user'])) {
                unset($_SESSION['error_user']);
            }
            $insert = insertUser(
                $extraCode,
                $firstName,
                $lastName,
                $fullName,
                $email,
                $phone,
                $address,
                $birthday,
                $gender,
                $avatar,
                $biography,
                $information,
                $status
            );
            if ($insert) {
                header("Location:index.php?c=user&state=success");
            } else {
                header("Location:index.php?c=user&m=add&state=error");
            }
        }
    }
}

function Add()
{
    // Render add user view
    require APP_PATH_VIEW . 'users/add_view.php';
}

function index()
{
    $keyword = trim($_GET['search'] ?? null);
    $keyword = strip_tags($keyword);
    $page = trim($_GET['page'] ?? null);
    $page = (is_numeric($page) && $page > 0) ? $page : 1;
    $linkPage =createlink([
        'c'=>'user',
        'm'=>'index',
        'page'=> '{page}',
        'search'=>$keyword
    ]);
    $itemUsers = getAllDataUsers($keyword); 
    $itemUsers = count($itemUsers);
    $pagination = pagination($linkPage,$itemUsers,$page, LIMIT_ITEM_PAGE);
    $start = $pagination['start'] ?? 0;
    $users = getAllDataUsersByMyPage($keyword,$start,LIMIT_ITEM_PAGE);
    $htmlPage =$pagination['htmlPage'] ?? null;
    require APP_PATH_VIEW . 'users/index_view.php';

}
?>
