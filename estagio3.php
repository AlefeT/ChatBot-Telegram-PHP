<?php

//include("functions.php");

if ($estagio == '3'){
	
	$query = mysqli_query($db, "SELECT tipoenvio FROM db.tabela WHERE senderid=$chatId;");
	$row = mysqli_fetch_row($query);
	$tipoenvio = $row[0];
	
	if ($tipoenvio == "E")
	{
		
		$query = mysqli_query($db, "SELECT numdivida FROM db.tabela WHERE senderid=$chatId;");
		$row = mysqli_fetch_row($query);
		$numdivida = $row[0];
	
		$query = mysqli_query($db, "SELECT numcredor FROM db.tabela WHERE senderid=$chatId;");
		$row = mysqli_fetch_row($query);
		$numcredor = $row[0];
	
		$hoje = (string)date("d/m/Y");
		$datapagto = $hoje;
	
		$query = mysqli_query($db, "SELECT cpf FROM db.tabela WHERE senderid=$chatId;");
		$row = mysqli_fetch_row($query);
		$cpfcliente = $row[0];
	
		$email = $text;
		
		$resultado = enviarFaturaemail($numcredor,$numdivida,$cpfcliente,$datapagto,$email);
		
        // Caso ocorra erro ao conectar ao webservice
        if ($resultado != 1) {
        
		$reply = urlencode("O boleto foi enviado para o seu e-mail com sucesso. A abc agradece pelo contato, tenha um bom dia.");
		
		file_get_contents($website."/sendmessage?chat_id=".$chatId."&text=".$reply);
        }
        
        else {
        
        $reply = urlencode("Serviço temporariamente indisponível. Tente novamente mais tarde.");
		
	   file_get_contents($website."/sendmessage?chat_id=".$chatId."&text=".$reply);
        
    }
	
	}
	
	if ($tipoenvio == "S")
	{
		
		$sms = $text;
	
		$query = mysqli_query($db, "SELECT numdivida FROM db.tabela WHERE senderid=$chatId;");
		$row = mysqli_fetch_row($query);
		$numdivida = $row[0];
	
		$query = mysqli_query($db, "SELECT numcredor FROM db.tabela WHERE senderid=$chatId;");
		$row = mysqli_fetch_row($query);
		$numcredor = $row[0];
		
		$hoje = (string)date("d/m/Y");
		$datapagto = $hoje;
	
	
		$query = mysqli_query($db, "SELECT cpf FROM db.tabela WHERE senderid=$chatId;");
		$row = mysqli_fetch_row($query);
		$cpfcliente = $row[0];
	
		$resultado = enviarFaturasms($numcredor,$numdivida,$cpfcliente,$datapagto,$sms);
		
        // Caso ocorra erro ao conectar ao webservice
        if ($resultado != 1) {
        
		$reply = urlencode("A linha digitável foi enviada via SMS com sucesso. A abc agradece pelo contato, tenha um bom dia.");
		
		file_get_contents($website."/sendmessage?chat_id=".$chatId."&text=".$reply);
        }
        
        else {
        
        $reply = urlencode("Serviço temporariamente indisponível. Tente novamente mais tarde.");
		
	   file_get_contents($website."/sendmessage?chat_id=".$chatId."&text=".$reply);
        
    }
		
	}
	
	mysqli_query($db, "DELETE FROM db.tabela WHERE senderid = $chatId;");
	
	//RECORD ACORDO
	date_default_timezone_set('America/Sao_Paulo');

	$horario = date("y-m-d H:i:s");

	$db2 = mysqli_connect("db.db.db.db", "db", "db", "db"); 

	mysqli_query($db2, "INSERT INTO ACORDO_LOG (canal, horario, contratante, cpfcliente) VALUES ('TELEGRAM','$horario','abc','$cpfcliente');");
	//END RECORD ACORDO

}

?>