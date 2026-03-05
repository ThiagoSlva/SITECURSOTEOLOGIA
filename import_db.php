<?php
// import_db.php
require_once __DIR__ . '/includes/db.php';

$sql = file_get_contents(__DIR__ . '/database.sql');

// Remove the CREATE DATABASE and USE commands as they might fail if the user is restricted to a single DB
// And we're already connected to the given DB
$sql = preg_replace('/CREATE DATABASE IF NOT EXISTS `.*?` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;/', '', $sql);
$sql = preg_replace('/USE `.*?`;/', '', $sql);

try {
    $pdo->exec($sql);
    echo "Sucesso ao importar schema!\n";
}
catch (PDOException $e) {
    echo "Erro ao importar: " . $e->getMessage() . "\n";
}
