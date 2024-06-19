<?php
if (!defined('SERVER')) define('SERVER', 'mysql302.phy.lolipop.lan');
if (!defined('DBNAME')) define('DBNAME', 'LAA1516825-aso');
if (!defined('USER')) define('USER', 'LAA1516825');
if (!defined('PASS')) define('PASS', 'aso1234');

$connect = 'mysql:host=' . SERVER . ';dbname=' . DBNAME . ';charset=utf8';
$pdo = new PDO($connect, USER, PASS);
?>
