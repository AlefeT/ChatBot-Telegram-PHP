<?php
if ($counter==0){
    
	$rv = mysqli_query($db, "INSERT INTO db.tabela(senderid, estagio, unixtime) VALUES ('$chatId','1', $currentunix);");

    // Caso ocorra erro ao atualizar o estagio ou conectar com o banco de dados-- 
    if ($rv == false ){
        // Mensagem de erro 
        $reply = urlencode("Erro de conexão com o servidor. Tente novamente.");
		
	file_get_contents($website."/sendmessage?chat_id=".$chatId."&text=".$reply);
    }
    
    else {
    
    $reply = urlencode("Olá, sou Carol sua agente digital abc. Para que possamos começar seu atendimento, por favor digite seu CPF/CNPJ, sem pontos ou traços.");
		
	file_get_contents($website."/sendmessage?chat_id=".$chatId."&text=".$reply);
    
    }
}

?>