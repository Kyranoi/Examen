<?php
include("db_config.php");
if (isset($_GET['klant_id'])) {
    $id = $_GET['klant_id'];
    $checkid = $pdo->prepare("select * from klant where klant_id = '" . $id . "'"); //to check id
    $checkid->execute();
    if ($checkid->rowCount() > 0 ) {
        $insert_query = $pdo->prepare("delete from klant where klant_id = :klant_id");
        try {
            $pdo->beginTransaction();
            $insert_query->bindParam(":klant_id", $id);
            $count = $insert_query->execute();

            if ($count> 0) {
                header("Location: delete.php");
                header("Location: reserveer.php?message=Record has been deleted succesfully");
            } else {
                header("Location: index.php?message=Failed to delete");
            }
            $pdo->commit();
        }
        catch (PDOException $e) {
            $dbh->rollback();
            print "Error!: " . $pdo->getMessage() . "</br>";
        }
    } else {
        header("Location: index.php?message=Invalid reqeust");
    }
}

?>