<?php
require "database/database.php";

function updateCourseById(
    $departmentId,
    $name,
    $slug,
    $description,
    $status,
    $id
) {
    date_default_timezone_set('Asia/Ho_Chi_Minh');
    $db = connectionDb();
    $checkUpdate = false;   
    $sql = "UPDATE `courses` SET `department_id` = :departmentId, `name` = :nameCourse, `slug` = :slug, `description` = :description, `status` = :statusCourse, `updated_at` = :updated_at WHERE `id` = :id AND `deleted_at` IS NULL";
    $updateTime = date('Y-m-d H:i:s');
    $stmt = $db->prepare($sql);
    if($stmt){
        $stmt->bindParam(':departmentId', $departmentId, PDO::PARAM_INT);
        $stmt->bindParam(':nameCourse', $name, PDO::PARAM_STR);
        $stmt->bindParam(':slug', $slug, PDO::PARAM_STR);
        $stmt->bindParam(':description', $description, PDO::PARAM_STR);
        $stmt->bindParam(':statusCourse', $status, PDO::PARAM_INT);
        $stmt->bindParam(':updated_at', $updateTime, PDO::PARAM_STR);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        if($stmt->execute()){
            $checkUpdate = true;
        }
    }
    disconnectionDb($db);
    return $checkUpdate;
}

function getDetailCourseById($id = 0){
    $db = connectionDb();
    $sql = "SELECT * FROM `courses` WHERE `id` = :id AND `deleted_at` IS NULL";
    $stmt = $db->prepare($sql);
    $infoCourse = [];
    if($stmt){
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        if($stmt->execute()){
            if($stmt->rowCount() > 0){
                $infoCourse = $stmt->fetch(PDO::FETCH_ASSOC);
            }
        }   
    }
    disconnectionDb($db);
    return $infoCourse;
}

function deleteCourseById($id = 0){
    date_default_timezone_set('Asia/Ho_Chi_Minh');
    $db = connectionDb();
    $sql = "UPDATE `courses` SET `deleted_at` = :deleted_at WHERE `id` = :id";
    $deletedAt = date("Y-m-d H:i:s");
    $stmt = $db->prepare($sql);
    $checkDelete = false;
    if($stmt){
        $stmt->bindParam(':deleted_at', $deletedAt, PDO::PARAM_STR);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        if($stmt->execute()){
            $checkDelete = true;
        }
    }
    disconnectionDb($db);
    return $checkDelete;
}
function getAllDataCoursesByMyPage($keyword=null, $start = 0, $limit = LIMIT_ITEM_PAGE)
{
    $db = connectionDb();
    $key = "%{$keyword}%";
    $sql = "SELECT c.id, d.name AS department_name, c.name, c.slug, c.description, c.status, c.created_at, c.updated_at, c.deleted_at 
            FROM courses c 
            INNER JOIN departments d ON c.department_id = d.id 
            WHERE (c.name LIKE :keyword OR c.description LIKE :cdescription) 
            AND c.deleted_at IS NULL 
            LIMIT :startData, :limitData";
    
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':keyword', $key, PDO::PARAM_STR);
    $stmt->bindParam(':cdescription', $key, PDO::PARAM_STR); // Thay :cdescription thành :description
    $stmt->bindParam(':startData', $start, PDO::PARAM_INT);
    $stmt->bindParam(':limitData', $limit, PDO::PARAM_INT);
    
    $dataCourses = [];
    if($stmt->execute()){
        $dataCourses = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    disconnectionDb($db);
    return $dataCourses;
}


function getAllDataCourses($keyword = null){
    $db = connectionDb();
    $key = "%{$keyword}%";
    $sql = "SELECT c.id, d.name AS department_name, c.name, c.slug, c.description, c.status, c.created_at, c.updated_at, c.deleted_at 
    FROM courses c 
    INNER JOIN departments d ON c.department_id = d.id 
    WHERE (c.name LIKE :keyword OR c.description LIKE :cdescription) 
    AND c.deleted_at IS NULL 
   ";
    $stmt = $db->prepare($sql);
    $dataCourses = [];
    if($stmt){
        $stmt->bindParam(':keyword', $key, PDO::PARAM_STR);
        $stmt->bindParam(':cdescription', $key, PDO::PARAM_STR);
        if($stmt->execute()){
            if($stmt->rowCount() > 0){
                $dataCourses = $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
        }
    }
    disconnectionDb($db);
    return $dataCourses;
}

function insertCourse(
    $departmentId,
    $name,
    $slug,
    $description,
    $status
) {
    date_default_timezone_set('Asia/Ho_Chi_Minh');
    $db = connectionDb();
    $flagInsert = false;
    $sqlInsert = "INSERT INTO `courses`(`department_id`, `name`, `slug`, `description`, `status`, `created_at`) VALUES(:departmentId, :nameCourse, :slug, :descriptionCourse, :statusCourse, :created_at)";
    $stmt = $db->prepare($sqlInsert);
    $currentDate = date('Y-m-d H:i:s');
    if($stmt){
        $stmt->bindParam(':departmentId', $departmentId, PDO::PARAM_INT);
        $stmt->bindParam(':nameCourse', $name, PDO::PARAM_STR);
        $stmt->bindParam(':slug', $slug, PDO::PARAM_STR);
        $stmt->bindParam(':descriptionCourse', $description, PDO::PARAM_STR);
        $stmt->bindParam(':statusCourse', $status, PDO::PARAM_INT);
        $stmt->bindParam(':created_at', $currentDate, PDO::PARAM_STR);
        if($stmt->execute()){
            $flagInsert = true;
        }
        disconnectionDb($db);
    }
    return $flagInsert;
}