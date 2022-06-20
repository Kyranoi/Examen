<?php 
include("db_config.php");
$klantId = $_GET['klant_id'];
$klant = pdo($pdo, "select * from klant where klant_id = ?", [$klantId])->fetch();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>edit</title>
</head>

<body>
    <h2>Update Record in the Database</h2>

    <?php if (!empty($klant)) {?>

    <form action="update.php" method="post" >
        <input type="hidden" name="klant_id" value="<?php echo $_GET['klant_id']; ?>">
        <label>Naam</label>
        <input type="text" name="username" required="required" value="<?php  if(isset($klant['username'])){ echo $klant['username']; } ?>" /><br /><br />
        <label>Wachtwoord</label>
        <input type="text" name="pwd" required="required" value="<?php  if(isset($klant['pwd'])){ echo $klant['pwd']; } ?>" /><br /><br />
        <label>Telefoon</label>
        <input type="text" name="telefoon" required="required" value="<?php  if(isset($klant['telefoon'])){ echo $klant['telefoon']; } ?>" /><br /><br />
        <input type="submit" name="submit" required="required" value="submit" />
    </form>

    <?php }?>
</body>
</html>