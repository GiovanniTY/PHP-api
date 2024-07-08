<?php

require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

$dbHost = $_ENV['DB_HOST'];
$dbName = $_ENV['DB_DATABASE'];
$dbUser = $_ENV['DB_USERNAME'];
$dbPass = $_ENV['DB_PASSWORD'];

$pdo = new PDO("mysql:host=$dbHost;dbname=$dbName;charset=utf8", $dbUser, $dbPass);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

