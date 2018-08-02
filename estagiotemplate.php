<?php

//include("functions.php");

if ($estagio == 5){
	
if (!ctype_digit($msg)) {
    $data = array(
	'recipient' => array('id' =>"$rid"),
	'message' => array('text'=>"Mensagem enviada contem caracteres não númericos. Por favor digite somente um número sem pontos, traços ou caracteres especiais.")
	);
	
$options = array(
	'http' => array(
		'method' => 'POST',
		'content' => json_encode($data),
		'header' => "Content-Type: application/json\n"
));

$context = stream_context_create($options);

file_get_contents("https://graph.facebook.com/v2.6/me/messages?access_token=$token", false, $context);

}

if (ctype_digit($msg)){

	$data = array(
		'recipient' => array('id' =>"$rid"),
		'message' => array('text'=>"Estagio 5 em desenvolvimento.")
	);
	
	$options = array(
		'http' => array(
			'method' => 'POST',
			'content' => json_encode($data),
			'header' => "Content-Type: application/json\n"
	));

$context = stream_context_create($options);

file_get_contents("https://graph.facebook.com/v2.6/me/messages?access_token=$token", false, $context);

}

}

?>