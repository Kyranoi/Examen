<?php

include_once('db_config.php');

if (!empty($_POST)) {
    // insert
    pdo($pdo, "INSERT INTO klant (klant_id, username, pwd, telefoon) VALUES (null, ?,?,?)", [$_POST['username'], $_POST['pwd'], $_POST['telefoon']]);
    $klant_id = $pdo->lastInsertId();

    if($klant_id) {
        print_r($_POST);
        pdo($pdo, "INSERT INTO reservering (reserverings_id, klant_id, kamer_id, van, tot) VALUES (null, ?,?,?,?)", [$klant_id, $_POST['kamer_id'], $_POST['van'], $_POST['tot']]);
    }
}

$kamers = pdo($pdo, "SELECT kamer_id, eigenschappen FROM kamer")->fetchAll();


$options = '';

foreach ($kamers as $kamer) {
    $options .= "<option value=\"". $kamer['kamer_id']. "\">" . $kamer['eigenschappen'] . "</option><br>";
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reserveer</title>
</head>
<body>
    <a href="index.php" class="links">HOME</a>
    <a href="contact.php" class="links">CONTACT</a>

    <div class="container"> 
        <h5> Check beschikbaarheid </h5>
        <form action="reserveer.php" method="post">
                <input type="hidden" name="klant_id" required="required"><br>
                <label class="form-label" style="font-weight: 500;">Naam</label>
                <input type="text" name="username" placeholder="Naam" required="required"><br>
                <label class="form-label" style="font-weight: 500;">Wachtwoord</label>
                <input type="password" name="pwd" placeholder="Wachtwoord" required="required"><br>
                <label class="form-label" style="font-weight: 500;">Telefoonnummer</label>
                <input type="text" name="telefoon" placeholder="Telefoonnummer" required="required"><br>

                <div class="check-in">
                <label class="form-label" style="font-weight: 500;">Check-in</label>
                <input type="date" name="van" class="form-control"></div><br>
                <div class="check-out">
                <label class="form-label" style="font-weight: 500;">Check-out</label>
                <input type="date" name="tot" class="form-control"></div><br>
                <div class="Kamer">
                <label class="form-label" style="font-weight: 500;">Kamer</label>
                <select name="kamer_id" class="form-select">
                    <option selected>Kies een kamer</option>
                    <?php echo $options;?>
                </select>
                </div><br>
                <div class="check-button">
                    <button type="submit">Boek</button>
        </form>
    </div>

    <table border="1" width="900px" >

        <tr>
        <th>Klant Id</th>
        <th>Naam</th>
        <th>Wachtwoord</th>
        <th>Telefoonnummer</th>
        </tr>

        <?php 
        $get_datas = $pdo->prepare("SELECT * FROM klant");
        $get_datas->execute();
        if($get_datas->rowCount()>0){
        $i=1;
        while($res=$get_datas->fetch(PDO::FETCH_ASSOC)){
        ?>

        <tr>
        <td align="center"><?php echo $res['klant_id']; ?></td>
        <td align="center"><?php echo $res['username']; ?></td>
        <td align="center"><?php echo $res['pwd']; ?></td>
        <td align="center"><?php echo $res['telefoon']; ?></td>
        <td><a href="edit.php?klant_id=<?php echo $res['klant_id'];?>">Edit</a><br /><a href="delete.php?klant_id=<?php echo $res['klant_id'];?>">Delete</a></td>
        </tr>

        <?php } }else{
        echo "<tr><td colspan='5'>Records not found</td></tr>";
        } ?>

    </table>

    <script type="text/javascript">
        
        <?php if($_GET['message']){ ?>
            alert('<?php echo $_GET['message'];?>');
        <?php } ?>

    </script>
</body>
</html>