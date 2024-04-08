<?php
require 'model/CourseModel.php';

$m = trim($_GET['m'] ?? 'index'); // trim: remove leading and trailing whitespace
$m = strtolower($m); // convert to lowercase
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

        $name = trim($_POST['name'] ?? null);
        $name = strip_tags($name);

        $description = trim($_POST['description'] ?? null);
        $description = strip_tags($description);

        $status = trim($_POST['status'] ?? null);
        $status = $status === '0' || $status === '1' ? $status : 0;

        // Additional fields specific to courses table
        $departmentId = trim($_POST['department_id'] ?? null);
        $departmentId = is_numeric($departmentId) ? $departmentId : 0;

        // Additional field specific to courses table
        $slug = slugify($name);
        // Insert course into database
        $_SESSION['error_course'] = [];
        
     
    
        // Kiểm tra các trường bắt buộc
        if (empty($name)) {
            $_SESSION['error_course']['name'] = 'Enter name, please';
        } else {
            $_SESSION['error_course']['name'] = null;
        }
        if (empty($departmentId)) {
            $_SESSION['error_course']['department_id'] = "Select a department, please";
        } else {
            $_SESSION['error_course']['department_id'] = null;
        }

    

        $checkError = false;
        foreach($_SESSION['error_course'] as $error){
            if(!empty($error)){
                $checkError = true;
                break;
            }
        }
        if($checkError){
            // co loi xay ra
            // quay lai form update
            header("Location:index.php?c=course&m=edit&id={$id}");
        } else {
            // khong co loi gi ca
            // tien hanh update vao database
            if(isset($_SESSION['error_course'])){
                unset($_SESSION['error_course']);
            }
            $slug = slugify($name);
            
            $update = updateCourseById($departmentId, $name, $slug, $description, $status,$id);
            if($update){
                // thanh cong
                header("Location:index.php?c=course&state=success");
            } else {
                // that bai
                header("Location:index.php?c=course&m=edit&id={$id}&state=failure");
            }
        }
    
        // Kiểm tra xem có lỗi không
        // if (
        //     !empty($_SESSION['error_course']['name'])
        //     || !empty($_SESSION['error_course']['department_id'])
            
        // ) {
        //     // Nếu có lỗi, chuyển hướng về trang thêm mới
        //     header("Location:index.php?c=course&m=add&state=fail");
        // } else {
        //     // Nếu không có lỗi, thực hiện thêm mới vào database
        //     if (isset($_SESSION['error_course'])) {
        //         unset($_SESSION['error_course']);
        //     }
        //     $slug = slugify($name); // Tạo slug từ tên course
    
        //     // Gọi hàm để thêm mới vào database
        //     $update =updateCourseById($departmentId, $name, $slug, $description, $status,$id);
        //     if ($update) {
        //         header("Location:index.php?c=course&state=success");
        //     } else {
        //         header("Location:index.php?c=course&m=add&state=error");
        //     }
        // }
        
    }
}

function edit()
{
    $id = trim($_GET['id'] ?? null);
    $id = is_numeric($id) ? $id : 0;

    $infoDetail = getDetailCourseById($id);
    if (!empty($infoDetail)) {
        // Load edit view with course details
        require APP_PATH_VIEW . 'courses/edit_view.php';
    } else {
        // Show error view if course details not found
        require APP_PATH_VIEW . 'error_view.php';
    }
}

function handleDelete()
{
    $id = trim($_GET['id'] ?? null);
    $delete = deleteCourseById($id);

    // Redirect based on delete result
    if ($delete) {
        header("Location:index.php?c=course&state=delete_success");
    } else {
        header("Location:index.php?c=course&state=delete_failure");
    }
}

function handleAdd()
{
    if (isset($_POST['btnSaveCourse'])) {
        // Retrieve form data
        $name = trim($_POST['name'] ?? null);
        $name = strip_tags($name);

        $description = trim($_POST['description'] ?? null);
        $description = strip_tags($description);

        $status = trim($_POST['status'] ?? null);
        $status = $status === '0' || $status === '1' ? $status : 0;

        // Additional fields specific to courses table
        $departmentId = trim($_POST['department_id'] ?? null);
        $departmentId = is_numeric($departmentId) ? $departmentId : 0;

        // Additional field specific to courses table
        $slug = slugify($name);

        // Insert course into database
        $_SESSION['error_course'] = [];
        
     
    
        // Kiểm tra các trường bắt buộc
        if (empty($name)) {
            $_SESSION['error_course']['name'] = 'Enter name, please';
        } else {
            $_SESSION['error_course']['name'] = null;
        }
        if (empty($departmentId)) {
            $_SESSION['error_course']['department_id'] = "Select a department, please";
        } else {
            $_SESSION['error_course']['department_id'] = null;
        }
    
        // Kiểm tra xem có lỗi không
        if (
            !empty($_SESSION['error_course']['name'])
            || !empty($_SESSION['error_course']['department_id'])
            
        ) {
            // Nếu có lỗi, chuyển hướng về trang thêm mới
            header("Location:index.php?c=course&m=add&state=fail");
        } else {
            // Nếu không có lỗi, thực hiện thêm mới vào database
            if (isset($_SESSION['error_course'])) {
                unset($_SESSION['error_course']);
            }
            $slug = slugify($name); // Tạo slug từ tên course
    
            // Gọi hàm để thêm mới vào database
            $insert = insertCourse($departmentId, $name, $slug, $description, $status);
            if ($insert) {
                header("Location:index.php?c=course&state=success");
            } else {
                header("Location:index.php?c=course&m=add&state=error");
            }
        }
    }
}

function Add()
{
    // Load add view
    require APP_PATH_VIEW . 'courses/add_view.php';
}

function index()
{
    $keyword = trim($_GET['search'] ?? null);
    $keyword = strip_tags($keyword);
    $page = trim($_GET['page'] ?? null);
    $page = (is_numeric($page) && $page > 0) ? $page : 1;
    $linkPage = createlink([ 
        'c' => 'course',
        'm' => 'index',
        'page' => '{page}',
        'search' => $keyword
    ]);
    $itemCourses = getAllDataCourses($keyword); 
    $itemCourses = count($itemCourses);
    $pagination = pagination($linkPage, $itemCourses, $page, LIMIT_ITEM_PAGE);
    $start = $pagination['start'] ?? 0;
    $courses = getAllDataCoursesByMyPage($keyword, $start, LIMIT_ITEM_PAGE);
    $htmlPage = $pagination['htmlPage'] ?? null;
    require APP_PATH_VIEW . 'courses/index_view.php';
    
}

