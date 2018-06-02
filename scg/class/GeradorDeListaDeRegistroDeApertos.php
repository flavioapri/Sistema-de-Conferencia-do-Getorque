<?php
require_once 'class/RegistroDeAperto.php';
class GeradorDeListaDeRegistroDeApertos {

	static public function gerar() {
		$dadosExtraidos = GeradorDeListaDeRegistroDeApertos::extrairDadosDoArquivoFonte();
		return GeradorDeListaDeRegistroDeApertos::gerarLista($dadosExtraidos);
	}

	private function extrairDadosDoArquivoFonte() {
		$arquivoFonte = fopen('temp/novembro3.txt', 'r');
		$dadosExtraidos = array();
		
		while(!feof($arquivoFonte)) {
			array_push($dadosExtraidos, fgets($arquivoFonte));
		}
		
		fclose($arquivoFonte);
		array_shift($dadosExtraidos);
		return $dadosExtraidos;
	}

	private function gerarLista($dadosExtraidos) {
		$registrosDeAperto = array();
		
		foreach($dadosExtraidos as $linhaDeDados) {
			$linhaFracionada = preg_split("/[\t]/", $linhaDeDados);
			$registroDeAperto = new RegistroDeAperto($linhaFracionada[2], $linhaFracionada[3], $linhaFracionada[11], 
					$linhaFracionada[13]);
			array_push($registrosDeAperto, $registroDeAperto);
		}
		return $registrosDeAperto;
	}
}