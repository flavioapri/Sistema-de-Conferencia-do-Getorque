<?php
require_once 'class/Constantes.php';
require_once 'class/VerificadorDeItensPorCabina.php';

class ConferenteDeRegistrosDeAperto {
	private $listaDeCabinas;
	private $listaDeRegistrosDeAperto;
	private $tiposDeAperto;
	private $confirmacoes;
	private $verificadorDeItensPorCabina;
	private $listaDeCabinasVerificadas;
	private $ocorrencia;

	function __construct($listaDeCabinas, $listaDeRegistrosDeAperto, $tiposDeAperto) {
		$this->listaDeCabinas = $listaDeCabinas;
		$this->listaDeRegistrosDeAperto = $listaDeRegistrosDeAperto;
		$this->tiposDeAperto = $tiposDeAperto;
		$this->confirmacoes = array();
		$this->verificadorDeItensPorCabina = new VerificadorDeItensPorCabina();
		$this->listaDeCabinasVerificadas = array();
		$this->ocorrencia;
	}

	public function conferir() {
		foreach($this->listaDeCabinas as $cabina) {
			foreach($this->tiposDeAperto as $tipoDeAperto) {
				if($cabina->getBaumuster() !== $tipoDeAperto->getBaumuster()) {
					continue;
				}
				$contador = 0;
				foreach($this->listaDeRegistrosDeAperto as $registroDeAperto) {
					if($registroDeAperto->getIdentificador() === $cabina->getNpFormatado()) {
						
						if($tipoDeAperto->getNome() === $registroDeAperto->getNome() && $tipoDeAperto->getProcesso() === $registroDeAperto->getProcesso()) {
							
							if($registroDeAperto->getStatus() === Constantes::CONFIRMACAO) {
								$contador++;
							}
						}
					}
				}
				$this->verificarQtdDeApertosConfirmados($contador, $tipoDeAperto);
				$this->registrarOcorrencia($contador, $tipoDeAperto);
			}
			
			$cabina->setConfirmacoesDosApertos($this->confirmacoes);
			$cabina->getItemDeVerificacao()->setOcorrencia($this->ocorrencia);
			print_r(array_values($this->confirmacoes));
			echo "</br>";
			unset($GLOBALS['confirmacoes']);
			$this->confirmacoes = array();
			array_push($this->listaDeCabinasVerificadas, $cabina);
		}
		
		$lista = array();
		
		foreach($this->listaDeCabinasVerificadas as $cabina) {
		    $cabina = $this->verificadorDeItensPorCabina->verificar($cabina);
		    array_push($lista, $cabina);
		    echo " " . $cabina;
			echo "</br>";
		}
	}

	private function verificarQtdDeApertosConfirmados($contador, $tipoDeAperto) {
		if($contador == $tipoDeAperto->getQtdApertos())
			array_push($this->confirmacoes, Constantes::CONFIRMACAO);
		else
			array_push($this->confirmacoes, Constantes::NEGACAO);
	}

	private function registrarOcorrencia($contador, $tipoDeAperto) {
		if($contador > $tipoDeAperto->getQtdApertos())
			$this->ocorrencia .= "Apertos adicionais/ ";
		else if($contador < $tipoDeAperto->getQtdApertos())
			if($contador === 0)
				$this->ocorrencia .= "Sem registro de aperto/ ";
			else
				$this->ocorrencia .= "Faltam registros de aperto/ ";
	}
}

