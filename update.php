<?php
include("db_config.php");
$id = "" ;
$username   = "";
$pwd = "";
$telefoon  = "";

$hashed = password_hash($pwd, PASSWORD_DEFAULT);

if (isset($_POST['submit'])) {
    $username = htmlspecialchars($_POST['username']); // filter
    $hashed = htmlspecialchars($_POST['password']);
    $telefoon = htmlspecialchars($_POST['telefoon']); 
    $check_telefoon = pdo($pdo, "SELECT count(*) FROM klant where telefoon = :telefoon and klant_id != :klant_id", ['klant_id' => $id, 'telefoon' => $telefoon])->fetchColumn();
    if ($check_telefoon) {
        header("Location: index.php?message=Duplicate entry");
    } else {
        $insert_query = $pdo->prepare("UPDATE klant set username = :username, pwd=:pwd, telefoon=:telefoon where klant_id = :klant_id"); // insert data
        pdo(
            $pdo, 
            "UPDATE klant SET username = :username, pwd = :pwd, telefoon = :telefoon WHERE klant_id = :klant_id", 
            ['username' => $username, 'pwd' => $hashed, 'telefoon' => $telefoon, 'klant_id' => $id]
            );
        header("location:reserveer.php?klant_id=$id&message=Record has been updated successfully");
    }
}

/*
if (isset($_POST['submit'])) {
    $id = htmlspecialchars($_POST['klant_id']);
    $username = htmlspecialchars($_POST['username']);
    $hashed = htmlspecialchars($_POST['password']);
    $telefoon = htmlspecialchars($_POST['telefoon']); 

    $check_telefoon = pdo($pdo, "SELECT count(*) FROM klant where telefoon = :telefoon and klant_id != :klant_id", ['klant_id' => $id, 'telefoon' => $telefoon])->fetchColumn();

    if ($check_telefoon) {
        header("Location: index.php?message=Duplicate entry");
    } else {        
        pdo(
            $pdo, 
            "UPDATE klant SET username = :username, pwd = :password, telefoon = :telefoon WHERE klant_id = :klant_id", 
            ['username' => $username, 'pwd' => $hashed, 'telefoon' => $telefoon, 'klant_id' => $id]
        );
        header("location:reserveer.php?klant_id=$id&message=Record has been updated successfully");
    }
}
*/

?>



