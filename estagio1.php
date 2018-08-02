<?php

//include("functions.php");

if ($estagio == '1'){
	
if (!ctype_digit($text)) {
	
	$reply = urlencode("Mensagem enviada contem caracteres não númericos. Por favor digite um CPF sem traços e pontos para iniciar o atendimento.");
		
	file_get_contents($website."/sendmessage?chat_id=".$chatId."&text=".$reply);

}

if (ctype_digit($text)){
	
    $resultado = array();
	$resultado = getDadosdevedor($text);
	
    // Caso ocorra erro ao conectar ao webservice
    if ($resultado != 1) {
        
	$nomecliente = $resultado[1];
    $nrocredor = $resultado[2];
    $nrodivida = $resultado[3];
	$datavenc = $resultado[4];
	$principal = $resultado[5];
    $principal = floatval ($principal);
    $vtotal = $resultado[6];
	
	if($nomecliente != ''){
	
        // Gravar Cliente entrando no bot
        date_default_timezone_set('America/Sao_Paulo');

        $horario = date("y-m-d H:i:s");

        $db2 = mysqli_connect("db.db.db.db", "db", "db", "db"); 

        mysqli_query($db2, "INSERT INTO CANAL_LOG (canal, horario, contratante, cpfcliente) VALUES ('TELEGRAM','$horario','abc','$text');"); 
     
    // Atualiza estagio
	$rv = mysqli_query($db, "UPDATE db.tabela SET estagio = '2', cpf = '$text', datapagto = '$resultado[4]', numcredor = '$resultado[2]', numdivida = '$resultado[3]', unixtime = $currentunix WHERE senderid = $chatId;");
    
    // Caso ocorra erro ao atualizar o estagio ou conectar com o banco de dados-- 
    if ($rv == false ){
        // Mensagem de erro 
        $reply = urlencode("Erro de conexão com o servidor. Tente novamente.");
		
	file_get_contents($website."/sendmessage?chat_id=".$chatId."&text=".$reply);
    }
    else {
        
        $reply = urlencode("Olá, $nomecliente. Você possui uma fatura em atraso que venceu no dia $datavenc com o valor de ".number_format($principal, 2, ',', '.').".\nDigite a opção desejada para receber sua fatura\n\n1. E-MAIL\n2. SMS");
		
	file_get_contents($website."/sendmessage?chat_id=".$chatId."&text=".$reply);
        
    }
    }
     else {
         $reply = urlencode("O CPF não foi encontrado em nosso sistema. Tente novamente com outro CPF");
		
	file_get_contents($website."/sendmessage?chat_id=".$chatId."&text=".$reply);
    }
}
    
    else {
        
        $reply = urlencode("Serviço temporariamente indisponível. Tente novamente mais tarde.");
		
	file_get_contents($website."/sendmessage?chat_id=".$chatId."&text=".$reply);
        
    }
}

}

?>