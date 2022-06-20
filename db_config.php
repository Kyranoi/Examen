<?php 

$host = '127.0.0.1';
$db   = 'hotel_ter_duin';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];
try {
     $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
     throw new \PDOException($e->getMessage(), (int)$e->getCode());
}

function pdo($pdo, $sql, $args = NULL)
{
    if (!$args)
    {
         return $pdo->query($sql);
    }
    $stmt = $pdo->prepare($sql);
    $stmt->execute($args);
    return $stmt;
}


?> 