<?php
date_default_timezone_set('America/Sao_Paulo');

class GeradorDeArquivoDeConferencia {

	static public function gerar(array $listaDeConferencia, array $listaDeCabinas) {
		$data = GeradorDeArquivoDeConferencia::extrairDataDaConferencia($listaDeCabinas);		
		$nome = 'C:\Users\Flavio\Desktop\conferencia ' . $data . ' gerado em ' . date("d-m-Y His") . '.txt';
		
		$arquivo = fopen($nome, 'w');
		foreach($listaDeConferencia as $cabina) {
			$linha = $cabina . PHP_EOL;
			fwrite($arquivo, $linha);
		}
		fclose($arquivo);
	}

	static private function extrairDataDaConferencia(array $listaDeCabinas) {
		$primeiraCabina = $listaDeCabinas[0];
		return substr($primeiraCabina->getData(), 0, -9); // Retorna somente a data, sem a hora
	}
}