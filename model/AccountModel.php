<?php
require "database/database.php";

function updateAccountById(
    $roleId,
    $userId,
    $username,
    $password,
    $ipClient,
    $status,
    $id
) {
    date_default_timezone_set('Asia/Ho_Chi_Minh');
    $db = connectionDb();
    $checkUpdate = false;
    $sql = "UPDATE `accounts` SET `role_id` = :roleId, `user_id` = :userId, `username` = :username, `password` = :AccountPassword, `ip_client` = :ipClient,`status` = :AccountStatus, `updated_at` = :updatedAt WHERE `id` = :id AND `deleted_at` IS NULL";
    $stmt = $db->prepare($sql);
    if ($stmt) {
        $stmt->bindParam(':roleId', $roleId, PDO::PARAM_INT);
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->bindParam(':AccountPassword', $password, PDO::PARAM_STR);
        $stmt->bindParam(':ipClient', $ipClient, PDO::PARAM_STR);
        $stmt->bindParam(':AccountStatus', $status, PDO::PARAM_INT);
        $stmt->bindParam(':updatedAt', $updatedAt, PDO::PARAM_STR);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        if ($stmt->execute()) {
            $checkUpdate = true;
        }
    }
    disconnectionDb($db);
    return $checkUpdate;
}

function getDetailAccountById($id = 0)
{
    $db = connectionDb();
    $sql = "SELECT * FROM `accounts` WHERE `id` = :id AND `deleted_at` IS NULL";
    $stmt = $db->prepare($sql);
    $infoAccount = [];
    if ($stmt) {
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        if ($stmt->execute()) {
            if ($stmt->rowCount() > 0) {
                $infoAccount = $stmt->fetch(PDO::FETCH_ASSOC);
            }
        }
    }
    disconnectionDb($db);
    return $infoAccount;
}

function deleteAccountById($id = 0)
{
    date_default_timezone_set('Asia/Ho_Chi_Minh');

    $db = connectionDb();
    $sql = "UPDATE `accounts` SET `deleted_at` = :deletedAt WHERE `id` = :id";
    $deletedAt = date("Y-m-d H:i:s");
    $stmt = $db->prepare($sql);
    $checkDelete = false;
    if ($stmt) {
        $stmt->bindParam(':deletedAt', $deletedAt, PDO::PARAM_STR);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        if ($stmt->execute()) {
            $checkDelete = true;
        }
    }
    disconnectionDb($db);
    return $checkDelete;
}

function getAllDataAccounts($keyword = null)
{
    $db = connectionDb();
    $sql = "SELECT * FROM `accounts` WHERE (`username` LIKE :keyword OR `ip_client` LIKE :keyword) AND `deleted_at` IS NULL ";
    $stmt = $db->prepare($sql);
    $key = "%{$keyword}%";
    $data = [];
    if ($stmt) {
        $stmt->bindParam(':keyword', $key, PDO::PARAM_STR);
        if ($stmt->execute()) {
            if ($stmt->rowCount() > 0) {
                $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
        }
    }
    disconnectionDb($db);
    return $data;
}

function getAllDataAccountsByMyPage($keyword = null, $start = 0, $limit = LIMIT_ITEM_PAGE)
{
    $db = connectionDb();
    $key = "%{$keyword}%";
    $sql = "SELECT * FROM `accounts` WHERE (`username` LIKE :keyword OR `ip_client` LIKE :keyword) AND `deleted_at` IS NULL LIMIT :startData,:limitData";
    $stmt = $db->prepare($sql);
    $dataAccounts = [];
    if ($stmt) {
        $stmt->bindParam(':keyword', $key, PDO::PARAM_STR);
        $stmt->bindParam(':startData', $start, PDO::PARAM_INT);
        $stmt->bindParam(':limitData', $limit, PDO::PARAM_INT);
        if ($stmt->execute()) {
            if ($stmt->rowCount() > 0) {
                $dataAccounts = $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
        }
    }
    disconnectionDb($db);
    return $dataAccounts;
}

function insertAccount(
    $roleId,
    $userId,
    $username,
    $password,
    $ipClient,
    $status
) {
    date_default_timezone_set('Asia/Ho_Chi_Minh');
    $db = connectionDb();
    $flagInsert = false;
    $sqlInsert = "INSERT INTO `accounts`(`role_id`, `user_id`, `username`, `password`, `ip_client`,`status`,`created_at`) VALUES(:roleId, :userId, :username, :accountPassword, :ipClient,:accountStatus, :createdAt)";
    $stmt = $db->prepare($sqlInsert);
    $currentDate = date('Y-m-d H:i:s');
    if ($stmt) {
        $stmt->bindParam(':roleId', $roleId, PDO::PARAM_STR);
        $stmt->bindParam(':userId', $userId, PDO::PARAM_STR);
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->bindParam(':accountPassword', $password, PDO::PARAM_STR);
        $stmt->bindParam(':ipClient', $ipClient, PDO::PARAM_STR);
        $stmt->bindParam(':accountStatus', $status, PDO::PARAM_INT);
        $stmt->bindParam(':createdAt', $currentDate, PDO::PARAM_STR);
        if($stmt->execute()) {
            $flagInsert = true;
        }
        disconnectionDb($db); // ngat ket noi database
    }
    return $flagInsert;
}

