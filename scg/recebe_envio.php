<?php
require_once 'vendor/autoload.php';

// diretório de destino do arquivo
define('DEST_DIR', __DIR__ . '/uploads');

if(isset($_FILES['arquivos']) && !empty($_FILES['arquivos']['name'])) {
	// se o "name" estiver vazio, é porque nenhum arquivo foi enviado
	
	// cria uma variável para facilitar
	$arquivos = $_FILES['arquivos'];
	
	// total de arquivos enviados
	$total = count($arquivos['name']);
	
	// Renomeia os arquivos para facilitar o algorítimo
	
	
	for($i = 0; $i < $total; $i++) {
		// podemos acessar os dados de cada arquivo desta forma:
		// - $arquivos['name'][$i]
		// - $arquivos['tmp_name'][$i]
		// - $arquivos['size'][$i]
		// - $arquivos['error'][$i]
		// - $arquivos['type'][$i]
		
		if(!move_uploaded_file($arquivos['tmp_name'][$i],
							'C:\Users\Flavio\git\scg\uploads' . '/' . $arquivos['name'][$i])) {
			echo "Erro ao enviar o arquivo: " . $arquivos['name'][$i];
		}
	}
	
	Principal::iniciar(); // Inicia o processo de conferência
	
	echo "Conferência realizada com sucesso.";
}