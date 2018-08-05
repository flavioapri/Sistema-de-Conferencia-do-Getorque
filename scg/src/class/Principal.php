<?php

class Principal {

	public static function iniciar() {
		$conexao = new Conexao();
		
		$listaDeCabinas = GeradorDeListaDeCabinas::gerar();
		
		$listaDeRegistrosDeAperto = GeradorDeListaDeRegistroDeApertos::gerar();
		
		$tiposDeApertoDAO = new TipoDeApertoDAO($conexao->getConexao());
		
		$tiposDeAperto = $tiposDeApertoDAO->listarTiposDeApertoComBaumuster();
		
		$conferente = new ConferenteDeRegistrosDeAperto();
		
		$listaDeConferencia = $conferente->conferir($listaDeCabinas, $listaDeRegistrosDeAperto, $tiposDeAperto);
		
		GeradorDeArquivoDeConferencia::gerar($listaDeConferencia, $listaDeCabinas);
		
		FormatadorDePasta::removerArquivos();
	}
}