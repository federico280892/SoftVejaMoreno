<?php

$server = "localhost";
$user = "root";
$pass = "";
$dataBase = "clinica";

$userStock = "root";
$passStock = "";
$dbStock = "stockVeja";

//CLINICA
// $user = "c1370119_ges_VM";
// $pass = "BAsu28newo";
// $dataBase = "c1370119_ges_VM";

//STOCK
// $userStock = "c1370119_stock";
// $passStock = "BAsu28newo";
// $dbStock = "c1370119_stock";

$veja = mysqli_connect($server, $user, $pass, $dataBase);

$stock = mysqli_connect($server, $userStock, $passStock, $dbStock);

mysqli_set_charset($veja, "UTF8");

mysqli_set_charset($stock, "UTF8");

?>