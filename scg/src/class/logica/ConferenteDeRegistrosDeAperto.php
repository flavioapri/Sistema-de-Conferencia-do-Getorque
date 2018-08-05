<?php

class ConferenteDeRegistrosDeAperto {

	// TODO Método de encontrar o número do NP quando ele aparece com o número grande (PNR) não funcionando corretamente
	public function conferir(array $listaDeCabinas, array $listaDeRegistrosDeAperto, array $tiposDeAperto) {
		$verificadorDeItensPorCabina = new VerificadorDeItensPorCabina();
		$listaDeCabinasVerificadas = array();
		$confirmacoes = array();
		
		foreach($listaDeCabinas as $cabina) {
			foreach($tiposDeAperto as $tipoDeAperto) {
				if($cabina->getBaumuster() !== $tipoDeAperto->getBaumuster())
					continue;
				$contador = 0;
				foreach($listaDeRegistrosDeAperto as $registroDeAperto)
					if($registroDeAperto->getIdentificador() === $cabina->getNpFormatado())
						if($tipoDeAperto->getNome() === $registroDeAperto->getNome() &&
						$tipoDeAperto->getProcesso() === $registroDeAperto->getProcesso())
							if($registroDeAperto->getStatus() === Anotacao::CONFIRMACAO)
								$contador++;
				
				$confirmacao = $this->verificarQtdDeApertosConfirmados($contador, $tipoDeAperto);
				array_push($confirmacoes, $confirmacao);
			}
			
			$cabina->setConfirmacoesDosApertos($confirmacoes);
			$cabina = $verificadorDeItensPorCabina->verificar($cabina);			
			$confirmacoes = array();
			array_push($listaDeCabinasVerificadas, $cabina);
		}

		return $listaDeCabinasVerificadas;
	}

	private function verificarQtdDeApertosConfirmados($contador, TipoDeAperto $tipoDeAperto) {
		if($contador == $tipoDeAperto->getQtdApertos())
			return Anotacao::CONFIRMACAO;
		else
			return Anotacao::NEGACAO;
	}
}

