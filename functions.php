<?php 
/**
 * FraudCatcher bot
 * 
 * Licensed under the Simple Commercial License.
 * 
 * Copyright (c) 2024 Nikita Shkilov nikshkilov@yahoo.com
 * 
 * All rights reserved.
 * 
 * This file is part of FraudCatcher bot. The use of this file is governed by the
 * terms of the Simple Commercial License, which can be found in the LICENSE file
 * in the root directory of this project.
 */

function writeLogFile($string, $clear = false){
    $timeNow = TIME_NOW;
    $log_file_name = __DIR__."/temp/message.txt";
    if($clear == false) {
        $now = date("Y-m-d H:i:s");
        file_put_contents($log_file_name, $timeNow." ".print_r($string, true)."\r\n", FILE_APPEND);
    }
    else {
        file_put_contents($log_file_name, '');
        file_put_contents($log_file_name, $timeNow." ".print_r($string, true)."\r\n", FILE_APPEND);
    }
}

function debug($things, $decode=false, $clear=false) {

    $directory_path = $_SERVER['DOCUMENT_ROOT'] . '/temp';
    $file_path = $directory_path . '/debug.txt';
    if (!file_exists($directory_path)) {
        mkdir($directory_path, 0777, true);
    }
    $file = fopen($file_path, 'a+');

    if ($clear) {
        file_put_contents($file_path, '');
    }

    if ($decode) {
        $data = json_decode($things, true);
        $message = '[' . TIME_NOW . '] ' . print_r($data, true);
    } else {
        $message = '[' . TIME_NOW . '] ' . $things;
    }

    fwrite($file, $message . PHP_EOL);
    fclose($file);
}

function checkUser($userId){
    $dbCon = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $row = mysqli_query($dbCon, "SELECT userId FROM user WHERE userId='$userId'");
    $numRow = mysqli_num_rows($row);
    if ($numRow == 0) { return 'no_such_user'; } 
    elseif ($numRow == 1) { return 'one_user'; } 
    else { return false; error_log("ERROR! TWIN USER IN DB!");}
    mysqli_close($dbCon);
}

function createUser($user){
    $dbCon = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $username = "";
    $timeNow = TIME_NOW;
    if ($user['username']!='') { $username = $user['username']; } 
    else { $username = $user['first_name']." ".$user['last_name']; }
    mysqli_query($dbCon, "INSERT INTO user (userId, firstName, lastName, username, language, lastVisit, registeredAt) VALUES ('" . $user['id'] . "', '" . $user['first_name'] . "', '" . $user['last_name'] . "', '" . $username . "', '" . $user['language_code'] . "', '" . $timeNow . "', '" . $timeNow . "')");
    mysqli_close($dbCon);
}

function checkRole($userId) {
    $dbCon = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $roleQuery = mysqli_query($dbCon, "SELECT role FROM user WHERE userId='$userId'");
    $roleNumRow = mysqli_num_rows($roleQuery);
    if ($roleNumRow == 1) {
        $role = mysqli_fetch_assoc($roleQuery);
        $role = $role['role'];
        return $role;
    } else {
        return "no user";
    }
    mysqli_close($dbCon);
}

function userBlockedBot($userId) {
    $dbCon = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $query = mysqli_query($dbCon, "UPDATE user SET deleted='yes' WHERE userId='$userId'");
    mysqli_close($dbCon);
}

function userActivatedBot($userId) {
    $dbCon = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $query = mysqli_query($dbCon, "UPDATE user SET deleted='no' WHERE userId='$userId'");
    mysqli_close($dbCon);
}

function createLog($timestamp, $entity, $entityId, $context, $message) {
    $dbCon = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $message = mysqli_real_escape_string($dbCon, $message);
    $createLog = mysqli_query($dbCon, "INSERT INTO log (createdAt, entity, entityId, context, message) VALUES ('$timestamp', '$entity','$entityId','$context','$message')");
    if (!$createLog) {
        error_log("error with creating bot log in DB");
    }
    mysqli_close($dbCon);
}

function lang($userId) {
    $dbCon = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $languageResult = mysqli_query($dbCon, "SELECT language FROM user WHERE userId='$userId'");
    $row = mysqli_fetch_assoc($languageResult);
    $language = isset($row['language']) ? $row['language'] : "Unknown";
    mysqli_free_result($languageResult);
    mysqli_close($dbCon);
    
    return $language;
}

function changeLanguage($userId, $newLang) {
    $dbCon = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $query = mysqli_query($dbCon, "UPDATE user SET language='$newLang' WHERE userId='$userId'");
    mysqli_close($dbCon);
}

function createSupportMsg($userId, $msg){
    $dbCon = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $timeNow = TIME_NOW;
    mysqli_query($dbCon, "INSERT INTO support (userId, message, status, updated_at, created_at) VALUES ('$userId', '$msg', 'active', '$timeNow','$timeNow')");
    mysqli_close($dbCon);
}

function extractPhoneNumber($text) {
    if (preg_match('/\+[\d\s\-\(\)]{10,20}/', $text, $matches)) {
        $phoneNum = preg_replace('/[\s\-\(\)]/', '', $matches[0]);
        return $phoneNum;
    } else {
        return false;
    }
}

function searchPhone($phoneNum) {
    $timeNow = TIME_NOW;
    $dbCon = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $query = mysqli_query($dbCon, "SELECT * FROM phone WHERE phoneNum='$phoneNum'");
    $numRow = mysqli_num_rows($query);
    if ($numRow == 1) {
        return mysqli_fetch_assoc($query);
    } else {
        return false;
    }
    mysqli_close($dbCon);
}

function createPhone($phoneNum) {
    $timeNow = TIME_NOW;
    $dbCon = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $query = mysqli_query($dbCon, "INSERT INTO phone (phoneNum, updated_at, created_at) VALUES ('$phoneNum', '$timeNow', '$timeNow')");
    mysqli_close($dbCon);
}

function getPhoneSearches($phoneNum) {
    $timeNow = TIME_NOW;
    $dbCon = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $query = mysqli_query($dbCon, "SELECT * FROM log WHERE context='search' AND message='$phoneNum'");
    $numRow = mysqli_num_rows($query);
    return $numRow;
    mysqli_close($dbCon);
}

function getPhoneWarns($phoneNum) {
    $timeNow = TIME_NOW;
    $dbCon = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $query = mysqli_query($dbCon, "SELECT * FROM phone_warn WHERE phoneNum='$phoneNum'");
    $numRow = mysqli_num_rows($query);
    return $numRow;
    mysqli_close($dbCon);
}

function checkWarns($phoneNum, $userId) {
    $timeNow = TIME_NOW;
    $dbCon = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $checkWarns = mysqli_query($dbCon, "SELECT MAX(created_at) AS latest_warned_at FROM phone_warn WHERE userId='$userId' AND phoneNum='$phoneNum'");
    if ($checkWarns && mysqli_num_rows($checkWarns) > 0){
        $row = mysqli_fetch_assoc($checkWarns); 
        $latestWarnedAt = strtotime($row['latest_warned_at'])+3600;
        if ($latestWarnedAt > strtotime($timeNow)) {
            return false; //delay
        } else {
            return true;
        }
    } else {
        return true;
    }
    mysqli_close($dbCon);
}

function warnPhone($phoneNum, $userId, $reason) {
    $timeNow = TIME_NOW;
    $dbCon = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $reason = mysqli_real_escape_string($dbCon, $reason);
    $query = mysqli_query($dbCon, "INSERT INTO phone_warn (phoneNum, userId, reason, updated_at, created_at) VALUES ('$phoneNum', '$userId', '$reason', '$timeNow', '$timeNow')");
    mysqli_close($dbCon);
}

function superUpdater($db_table, $updateParam, $updateValue, $whereParam, $whereValue, $updater = true) {
    $timeNow = TIME_NOW;
    $dbCon = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if ($db_table == 'user') {
        mysqli_query($dbCon, "UPDATE $db_table SET $updateParam='$updateValue', lastVisit='$timeNow' WHERE $whereParam='$whereValue'");
    } else {
        mysqli_query($dbCon, "UPDATE $db_table SET $updateParam='$updateValue', updated_at='$timeNow' WHERE $whereParam='$whereValue'");
    }
    mysqli_close($dbCon);
}

?>