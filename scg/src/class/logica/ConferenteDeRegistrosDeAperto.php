<?php
require_once 'src/class/constantes/Constantes.php';
require_once 'src/class/logica/VerificadorDeItensPorCabina.php';

class ConferenteDeRegistrosDeAperto {

	public function conferir(array $listaDeCabinas, array $listaDeRegistrosDeAperto, array $tiposDeAperto) {
		$verificadorDeItensPorCabina = new VerificadorDeItensPorCabina();
		$listaDeCabinasVerificadas = array();
		$confirmacoes = array();
		$ocorrencia = NULL;
		
		foreach($listaDeCabinas as $cabina) {
			foreach($tiposDeAperto as $tipoDeAperto) {
				if($cabina->getBaumuster() !== $tipoDeAperto->getBaumuster())
					continue;
				$contador = 0;
				foreach($listaDeRegistrosDeAperto as $registroDeAperto)
					if($registroDeAperto->getIdentificador() === $cabina->getNpFormatado())
						if($tipoDeAperto->getNome() === $registroDeAperto->getNome() &&
						$tipoDeAperto->getProcesso() === $registroDeAperto->getProcesso())
							if($registroDeAperto->getStatus() === Constantes::CONFIRMACAO)
								$contador++;
				
				$confirmacao = $this->verificarQtdDeApertosConfirmados($contador, $tipoDeAperto);
				array_push($confirmacoes, $confirmacao);
				$ocorrencia .= $this->registrarOcorrencia($contador, $tipoDeAperto);
			}
			
			$cabina->setConfirmacoesDosApertos($confirmacoes);
			$cabina->getItemDeVerificacao()->setOcorrencia($ocorrencia);
			print_r(array_values($confirmacoes));
			echo "</br>";
			$confirmacoes = array();
			array_push($listaDeCabinasVerificadas, $cabina);
		}
		
		$lista = array();
		
		foreach($listaDeCabinasVerificadas as $cabina) {
			$cabina = $verificadorDeItensPorCabina->verificar($cabina);
			array_push($lista, $cabina);
			echo " " . $cabina;
			echo "</br>";
		}
	}

	private function verificarQtdDeApertosConfirmados($contador, TipoDeAperto $tipoDeAperto) {
		if($contador == $tipoDeAperto->getQtdApertos())
			return Constantes::CONFIRMACAO;
		else
			return Constantes::NEGACAO;
	}

	private function registrarOcorrencia($contador, TipoDeAperto $tipoDeAperto) {
		if($contador > $tipoDeAperto->getQtdApertos())
			return "Apertos adicionais/ ";
		else if($contador < $tipoDeAperto->getQtdApertos() && $contador > 0)
			return "Faltam registros de aperto/ ";
		else if($contador === 0)
			return "Sem registro de aperto/ ";
	}
}

