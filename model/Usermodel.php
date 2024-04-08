<?php
require "database/database.php";

function updateUser(
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
) {
    date_default_timezone_set('Asia/Ho_Chi_Minh');
    $db = connectionDb();
    $checkUpdate = false;
    $sql = "UPDATE `users` SET `extra_code` = :extraCode, `first_name` = :firstName, `last_name` = :lastName, `full_name` = :fullName, `email` = :email, `phone` = :phone, `address` = :addressUser, `birthday` = :birthday, `gender` = :gender, `avatar` = :avatar, `biography` = :biography, `information` = :information, `status` = :statusUser, `updated_at` = :updatedAt WHERE `id` = :id";
    $updatedAt = date('Y-m-d H:i:s');
    $stmt = $db->prepare($sql);
    if ($stmt) {
        $stmt->bindParam(':extraCode', $extraCode, PDO::PARAM_STR);
        $stmt->bindParam(':firstName', $firstName, PDO::PARAM_STR);
        $stmt->bindParam(':lastName', $lastName, PDO::PARAM_STR);
        $stmt->bindParam(':fullName', $fullName, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':phone', $phone, PDO::PARAM_STR);
        $stmt->bindParam(':addressUser', $address, PDO::PARAM_STR);
        $stmt->bindParam(':birthday', $birthday, PDO::PARAM_STR);
        $stmt->bindParam(':gender', $gender, PDO::PARAM_INT);
        $stmt->bindParam(':avatar', $avatar, PDO::PARAM_STR);
        $stmt->bindParam(':biography', $biography, PDO::PARAM_STR);
        $stmt->bindParam(':information', $information, PDO::PARAM_STR);
        $stmt->bindParam(':statusUser', $status, PDO::PARAM_INT);
        $stmt->bindParam(':updatedAt', $updatedAt, PDO::PARAM_STR);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        if ($stmt->execute()) {
            $checkUpdate = true;
        }
    }
    disconnectionDb($db);
    return $checkUpdate;
}

function getUserById($id)
{
    $db = connectionDb();
    $sql = "SELECT * FROM `users` WHERE `id` = :id";
    $stmt = $db->prepare($sql);
    $userInfo = [];
    if ($stmt) {
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        if ($stmt->execute()) {
            if ($stmt->rowCount() > 0) {
                $userInfo = $stmt->fetch(PDO::FETCH_ASSOC);
            }
        }
    }
    disconnectionDb($db);
    return $userInfo;
}

function deleteUser($id)
{
    date_default_timezone_set('Asia/Ho_Chi_Minh');
    $db = connectionDb();
    $sql = "DELETE FROM `users` WHERE `id` = :id";
    $stmt = $db->prepare($sql);
    $checkDelete = false;
    if ($stmt) {
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        if ($stmt->execute()) {
            $checkDelete = true;
        }
    }
    disconnectionDb($db);
    return $checkDelete;
}

function getAllDataUsers($keyword = null)
{
    $db = connectionDb();
    $sql = "SELECT * FROM `users` WHERE (`first_name` LIKE :keyword OR `last_name` LIKE :keyword OR `email` LIKE :keyword OR `phone` LIKE :keyword) AND `deleted_at` IS NULL";
    $stmt = $db->prepare($sql);
    $key = "%{$keyword}%";
    $users = [];
    if ($stmt) {
        $stmt->bindParam(':keyword', $key, PDO::PARAM_STR);
        if ($stmt->execute()) {
            if ($stmt->rowCount() > 0) {
                $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
        }
    }
    disconnectionDb($db);
    return $users;
}

function getAllDataUsersByMyPage($keyword = null, $start = 0, $limit = 10)
{
    $db = connectionDb();
    $key = "%{$keyword}%";
    $sql = "SELECT * FROM `users` WHERE (`first_name` LIKE :keyword OR `last_name` LIKE :keyword OR `email` LIKE :keyword OR `phone` LIKE :keyword) AND `deleted_at` IS NULL LIMIT :start, :limit";
    $stmt = $db->prepare($sql);
    $users = [];
    if ($stmt) {
        $stmt->bindParam(':keyword', $key, PDO::PARAM_STR);
        $stmt->bindParam(':start', $start, PDO::PARAM_INT);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        if ($stmt->execute()) {
            if ($stmt->rowCount() > 0) {
                $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
        }
    }
    disconnectionDb($db);
    return $users;
}

function insertUser(
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
) {
    date_default_timezone_set('Asia/Ho_Chi_Minh');
    $db = connectionDb();
    $flagInsert = false;
    $sqlInsert = "INSERT INTO `users`(`extra_code`, `first_name`, `last_name`, `full_name`, `email`, `phone`, `address`, `birthday`, `gender`, `avatar`, `biography`, `information`, `status`, `created_at`) VALUES(:extraCode, :firstName, :lastName, :fullName, :email, :phone, :addressUser, :birthday, :gender, :avatar, :biography, :information, :statusUser, :createdAt)";
    $stmt = $db->prepare($sqlInsert);
    $createdAt = date('Y-m-d H:i:s');
    if ($stmt) {
        $stmt->bindParam(':extraCode', $extraCode, PDO::PARAM_STR);
        $stmt->bindParam(':firstName', $firstName, PDO::PARAM_STR);
        $stmt->bindParam(':lastName', $lastName, PDO::PARAM_STR);
        $stmt->bindParam(':fullName', $fullName, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':phone', $phone, PDO::PARAM_STR);
        $stmt->bindParam(':addressUser', $address, PDO::PARAM_STR);
        $stmt->bindParam(':birthday', $birthday, PDO::PARAM_STR);
        $stmt->bindParam(':gender', $gender, PDO::PARAM_INT);
        $stmt->bindParam(':avatar', $avatar, PDO::PARAM_STR);
        $stmt->bindParam(':biography', $biography, PDO::PARAM_STR);
        $stmt->bindParam(':information', $information, PDO::PARAM_STR);
        $stmt->bindParam(':statusUser', $status, PDO::PARAM_INT);
        $stmt->bindParam(':createdAt', $createdAt, PDO::PARAM_STR);
        if ($stmt->execute()) {
            $flagInsert = true;
        }
        disconnectionDb($db); // ngat ket noi database
    }
    return $flagInsert;
}
