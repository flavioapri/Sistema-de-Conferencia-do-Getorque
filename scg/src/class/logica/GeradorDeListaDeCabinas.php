<?php

class GeradorDeListaDeCabinas {

	static public function gerar() {
		$dadosExtraidos = GeradorDeListaDeCabinas::extrairDadosDoArquivoFonte();
		return GeradorDeListaDeCabinas::gerarLista($dadosExtraidos);
	}

	private function extrairDadosDoArquivoFonte() {
		$linhasDoArquivo = file('uploads/cabinas.txt');		
		return $linhasDoArquivo;
	}

	private function gerarLista($dadosExtraidos) {
		$cabinas = array();
		
		foreach($dadosExtraidos as $linhaDeDados) {
			$linhaFracionada = preg_split("/[\t]/", $linhaDeDados);
			
			$cabina = new Cabina($linhaFracionada[0], $linhaFracionada[1], $linhaFracionada[2], $linhaFracionada[3],
								$linhaFracionada[4], $linhaFracionada[5], $linhaFracionada[6], $linhaFracionada[7],
								$linhaFracionada[8], $linhaFracionada[9], $linhaFracionada[10], $linhaFracionada[11],
								$linhaFracionada[12], $linhaFracionada[13], $linhaFracionada[14]);
			array_push($cabinas, $cabina);
		}
		
		return $cabinas;
	}
}