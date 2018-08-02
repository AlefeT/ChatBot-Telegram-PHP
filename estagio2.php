<?php

//include("functions.php");

if ($estagio == '2'){
	
if (!ctype_digit($text)) {
	
	$reply = urlencode("Mensagem enviada contem caracteres não númericos. Por favor digite um número válido sem pontos ou traços.");
		
	file_get_contents($website."/sendmessage?chat_id=".$chatId."&text=".$reply);

}

if (ctype_digit($text)){
	
	if($text < 1 || $text > 2){
		
		$reply = urlencode("Número inválido. Por favor digite um número válido (1 ou 2).");
		
		file_get_contents($website."/sendmessage?chat_id=".$chatId."&text=".$reply);
		
		$message = "Número inválido. Por favor digite um número válido (1 ou 2).";
		
	}
	
	if($text == 1){
		
		$rv = mysqli_query($db, "UPDATE db.tabela SET tipoenvio = 'E', estagio = '3', unixtime = $currentunix WHERE senderid = $chatId;");
		
        // Caso ocorra erro ao atualizar o estagio ou conectar com o banco de dados-- 
        if ($rv == false ){
        // Mensagem de erro
        $reply = urlencode("Erro de conexão com o servidor. Tente novamente.");
		
		file_get_contents($website."/sendmessage?chat_id=".$chatId."&text=".$reply);   
        }
         
        else {
        
        $reply = urlencode("Entendido, por favor digite o e-mail no qual você gostaria de receber o boleto.");
		
		file_get_contents($website."/sendmessage?chat_id=".$chatId."&text=".$reply);
        
        }
	}
	
	if($text == 2){
	
		$rv = mysqli_query($db, "UPDATE db.tabela SET tipoenvio = 'S', estagio = '3', unixtime = $currentunix WHERE senderid = $chatId;");
		
        // Caso ocorra erro ao atualizar o estagio ou conectar com o banco de dados-- 
        if ($rv == false ){
        // Mensagem de erro
        $reply = urlencode("Erro de conexão com o servidor. Tente novamente.");
		
		file_get_contents($website."/sendmessage?chat_id=".$chatId."&text=".$reply); 
        }
        
        else {
        
        $reply = urlencode("Entendido, por favor digite o número do celular (com DDD) no qual você gostaria de receber a linha digitável.");
		
		file_get_contents($website."/sendmessage?chat_id=".$chatId."&text=".$reply);
        
        }
	}
	
}

}

?>