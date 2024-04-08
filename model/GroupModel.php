<?php
require "database/database.php";

function updateGroupById(
    $departmentId,
    $name,
    $slug,
    $studentNumber,
    $userId,
    $status,
    $updatedAt,
    $id
) {
    // Cập nhật múi giờ Vietnamese
    date_default_timezone_set('Asia/Ho_Chi_Minh');
    $db = connectionDb();
    $checkUpdate = false;
    $sql = "UPDATE `groups` SET `department_id` = :departmentId, `name` = :groupName, `slug` = :slug, `student_number` = :studentNumber, `user_id` = :userId, `status` = :statusGroup, `updated_at` = :updatedAt WHERE `id` = :id";
    $stmt = $db->prepare($sql);
    if($stmt){
        $stmt->bindParam(':departmentId', $departmentId, PDO::PARAM_INT);
        $stmt->bindParam(':groupName', $name, PDO::PARAM_STR);
        $stmt->bindParam(':slug', $slug, PDO::PARAM_STR);
        $stmt->bindParam(':studentNumber', $studentNumber, PDO::PARAM_INT);
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->bindParam(':statusGroup', $status, PDO::PARAM_INT);
        $stmt->bindParam(':updatedAt', $updatedAt, PDO::PARAM_STR);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        if($stmt->execute()){
            $checkUpdate = true;
        }
    }
    disconnectionDb($db);
    return $checkUpdate;
}

function getDetailGroupById($id = 0){
    $db = connectionDb();
    $sql = "SELECT * FROM `groups` WHERE `id` = :id";
    $stmt = $db->prepare($sql);
    $infoGroup = [];
    if($stmt){
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        if($stmt->execute()){
            if($stmt->rowCount() > 0){
                $infoGroup = $stmt->fetch(PDO::FETCH_ASSOC);
            }
        }   
    }
    disconnectionDb($db);
    return $infoGroup;
}

function deleteGroupById($id = 0){
    // Cập nhật múi giờ Vietnamese
    date_default_timezone_set('Asia/Ho_Chi_Minh');

    $db = connectionDb();
    $sql = "UPDATE `groups` SET `deleted_at` = :deletedAt WHERE `id` = :id";
    $stmt = $db->prepare($sql);
    $deletedAt = date("Y-m-d H:i:s");
    $checkDelete = false;
    if($stmt){
        $stmt->bindParam(':deletedAt', $deletedAt, PDO::PARAM_STR);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        if($stmt->execute()){
            $checkDelete = true;
        }
    }
    disconnectionDb($db);
    return $checkDelete;
}
                                                
function getAllDataGroups($keyword = null) 
{
    $db = connectionDb();
    $sql = "SELECT * FROM `groups` WHERE (`name` LIKE :keyword OR `department_id` LIKE :departmentId) AND `deleted_at` IS NULL ";
    $stmt = $db->prepare($sql);
    $key = "%{$keyword}%";
    $data = [];
    if($stmt){
        $stmt->bindParam(':keyword', $key, PDO::PARAM_STR);
        $stmt->bindParam(':departmentId', $key, PDO::PARAM_STR);
        if($stmt->execute()){
            if($stmt->rowCount() > 0){
                $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
        }
    }
    disconnectionDb($db);
    return $data;
}

function  getAllDataGroupsByMyPage($keyword = null,$start =0, $limit =LIMIT_ITEM_PAGE) {
    $db = connectionDb();
    $key = "%{$keyword}%";
    $sql = "SELECT * FROM `groups` WHERE (`name` LIKE :keyword OR `department_id` LIKE :departmentId) AND `deleted_at` IS NULL LIMIT :startData,:limitData";
    $stmt = $db->prepare($sql);
    $dataGroups = [];
    if($stmt){
        $stmt->bindParam(':keyword', $key, PDO::PARAM_STR);
        $stmt->bindParam(':departmentId', $key, PDO::PARAM_STR);
        $stmt->bindParam(':startData', $start, PDO::PARAM_INT);
        $stmt->bindParam(':limitData', $limit, PDO::PARAM_INT);
        if($stmt->execute()){
            if($stmt->rowCount() > 0){
                $dataGroups = $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
        }
    }
    disconnectionDb($db);
    return $dataGroups;
}

function insertGroup(
    $departmentId,
    $name,
    $slug,
    $studentNumber,
    $userId,
    $status,
    $currentDate
) {
    // Cập nhật múi giờ Vietnamese
    date_default_timezone_set('Asia/Ho_Chi_Minh');
    $db = connectionDb();
    $flagInsert = false;
    $sqlInsert = "INSERT INTO `groups`(`department_id`, `name`, `slug`, `student_number`, `user_id`, `status`, `created_at`) VALUES(:departmentId, :nameGroup, :slug, :studentNumber, :userId, :statusGroup, :createdAt)";
    $stmt = $db->prepare($sqlInsert);
    $currentDate = date('Y-m-d H:i:s');
    if($stmt){
        $stmt->bindParam(':departmentId', $departmentId, PDO::PARAM_INT);
        $stmt->bindParam(':nameGroup', $name, PDO::PARAM_STR);
        $stmt->bindParam(':slug', $slug, PDO::PARAM_STR);
        $stmt->bindParam(':studentNumber', $studentNumber, PDO::PARAM_INT);
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->bindParam(':statusGroup', $status, PDO::PARAM_INT);
        $stmt->bindParam(':createdAt', $currentDate, PDO::PARAM_STR);
       
        if($stmt->execute()){
            $flagInsert = true;
        }
        disconnectionDb($db); // Ngắt kết
    }
    return $flagInsert;
}