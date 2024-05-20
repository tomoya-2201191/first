<?php
    const SERVER = 'mysql302.phy.lolipop.lan';
    const DBNAME = 'LAA1516825-aso';
    const USER = 'LAA1516825';
    const PASS = 'aso1234';

    $connect = 'mysql:host='. SERVER . ';dbname='. DBNAME . ';charset=utf8';
    $pdo = new PDO($connect,USER,PASS);
?>