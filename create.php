<?php

// create.php
// insert record in the table

include("db_config.php");
$username   = "";
$pwd = "";
$telefoon = "";

$hashed = password_hash($pwd, PASSWORD_DEFAULT);

if (isset($_POST['submit'])) {
    $username = filter_var($_POST['username'], FILTER_SANITIZE_STRING); // to filter string
    $telefoon  = filter_var($_POST['telefoon'], FILTER_SANITIZE_NUMBER_INT);
    $hashed = ($_POST['pwd']);
    $check_telefoon = $pdo->prepare("select * from klant where telefoon = '" . $telefoon . "' and klant_id not in ('".$id."')"); // to check duplicate
    $check_telefoon->execute();
    if ($check_telefoon->rowCount() > 0) {
        header("Location: index.php?message=Duplicate entry");
    } else {
        $insert_query = $pdo->prepare("INSERT INTO klant (username,pwd,telefoon) VALUES (:username,:pwd,:telefoon)"); //to insert data in the table
        try {
            $pdo->beginTransaction();
            $insert_query->bindParam(":username", $username);
            $insert_query->bindParam(":pwd", $hashed);
            $insert_query->bindParam(":telefoon", $telefoon);
            $insert_query->execute();
            if ($pdo->lastInsertId() > 0) {
                header("Location: reserveer.php"); //success data insertion
                header("Location: reserveer.php?message=Record has been inserted successfully")
            } else {
                header("Location: index.php?message=Failed to insert"); //failure data insertion
            }
            $pdo->commit();
        }
        catch (PDOExecption $e) {
            $dbh->rollback();
            print "Error!: " . $pdo->getMessage() . "</br>"; //exception
        }
    }
}
?>