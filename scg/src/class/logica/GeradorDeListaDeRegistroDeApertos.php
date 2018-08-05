<?php

class GeradorDeListaDeRegistroDeApertos {

	static public function gerar() {
		$dadosExtraidos = GeradorDeListaDeRegistroDeApertos::extrairDadosDoArquivoFonte();
		return GeradorDeListaDeRegistroDeApertos::gerarLista($dadosExtraidos);
	}

	private function extrairDadosDoArquivoFonte() {
		$linhasDoArquivo = file('uploads/apertos.txt');
		/* Remove a primeira linha do arquivo que é o cabeçalho da tabela, gera erro */
		array_shift($linhasDoArquivo);
		$numeroDeLinhas = count($linhasDoArquivo);
		/* A ultima linha do arquivo sempre estará em branco, como isso gera erro a linha abaixo excluí o ultimo
		  elemento do array que é a respectiva última linha. */
		unset($linhasDoArquivo[$numeroDeLinhas - 1]);
		return $linhasDoArquivo;
	}

	private function gerarLista($dadosExtraidos) {
		$registrosDeAperto = array();
		
		foreach($dadosExtraidos as $linhaDeDados) {
			/* Fraciona as linhas de acordo com os campos que estão separados por tabulação */
			$linhaFracionada = preg_split("/[\t]/", $linhaDeDados);
			$registroDeAperto = new RegistroDeAperto($linhaFracionada[2], $linhaFracionada[3], $linhaFracionada[11],
													$linhaFracionada[13]);
			array_push($registrosDeAperto, $registroDeAperto);
		}
		return $registrosDeAperto;
	}
}