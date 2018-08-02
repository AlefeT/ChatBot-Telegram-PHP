<?php
//Including functions
include("functions.php");

date_default_timezone_set('America/Sao_Paulo');

$currentunix = time();

//Connecting to database
$db = mysqli_connect("db.db.db.db.db", "db", "db", "db"); 

//set up the Bot API token
$botToken = "token";
$website = "https://api.telegram.org/bot".$botToken;

//Grab the info from the webhook, parse it and put it into $message
$content = file_get_contents("php://input");
$update = json_decode($content, TRUE);
$message = $update["message"];

//Make some helpful variables
$chatId = $message["chat"]["id"];
$text = $message["text"];

$query = mysqli_query($db, "SELECT COUNT(*) FROM db.tabela WHERE senderid=$chatId;");
$row = mysqli_fetch_row($query);
$counter = $row[0];
    
//WELCOME MESSAGE/FIRST TIME VISITING
include("estagio0.php");

//REST
if ($counter>0){
	
$query = mysqli_query($db, "SELECT estagio FROM db.tabela WHERE senderid=$chatId;");
$row = mysqli_fetch_row($query);
$estagio = $row[0];

//ESTAGIO 1 (RECEBER CPF)
include "estagio1.php";

//ESTAGIO 2 (RECEBER CPF)
include "estagio2.php";

//ESTAGIO 3 (RECEBER CPF)
include "estagio3.php";

}

?>