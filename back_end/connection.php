<?php

	$host = "localhost"; // endereço do servidor
	$usuario = "root"; // usuário do MySQL
	$senha = ""; // senha do MySQL
	$database = "Blog"; // nome do banco de dados

	// Cria a conexão
	$conn = new mysqli($host, $usuario, $senha, $database);
	
	// Checa se a conexão foi realizada com sucesso
	if ($conn->connect_error) {
	    die("Falha de conexão: " . $conn->connect_error);
	}

?>