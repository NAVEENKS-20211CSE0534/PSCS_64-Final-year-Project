<?php
$host = "127.0.0.1";
$port = 3306;
$username = "username";
$password = "password";
$database = "students";

$db = new PDO("mysql:host=$host;port=$port",
               $username,
               $password);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// other init
date_default_timezone_set("UTC");
session_start();

$db->exec("CREATE DATABASE IF NOT EXISTS `$database`");
$db->exec("use `$database`");

function tableExists($dbh, $id)
{
    $results = $dbh->query("SHOW TABLES LIKE '$id'");
    if(!$results) {
        return false;
    }
    if($results->rowCount() > 0) {
        return true;
    }
    return false;
}

$exists = tableExists($db, "faculty");

if (!$exists) {
    //create the database
    $db->exec("CREATE TABLE faculty (
    faculty_id   INTEGER       PRIMARY KEY AUTO_INCREMENT NOT NULL,
    faculty_name VARCHAR (100) NOT NULL
    );");

    $db->exec("CREATE TABLE appointment (
    appointment_id              INTEGER       PRIMARY KEY AUTO_INCREMENT NOT NULL,
    appointment_start           DATETIME      NOT NULL,
    appointment_end             DATETIME      NOT NULL,
    appointment_patient_name    VARCHAR (100),
    appointment_status          VARCHAR (100) DEFAULT 'free' NOT NULL,
    appointment_patient_session VARCHAR (100),
    faculty_id                   INTEGER       NOT NULL
    );");

    $items = array(
        array('name' => 'faculty 1'),
        array('name' => 'faculty 2'),
        array('name' => 'faculty 3'),
        array('name' => 'faculty 4'),
        array('name' => 'faculty 5'),
    );
    $insert = "INSERT INTO faculty (faculty_name) VALUES (:name)";
    $stmt = $db->prepare($insert);
    $stmt->bindParam(':name', $name);
    foreach ($items as $m) {
      $name = $m['name'];
      $stmt->execute();
    }

}

