<?php
require_once 'src/class/constantes/Constantes.php';
require_once 'src/class/modelo/Cabina.php';
require_once 'src/class/constantes/PosicaoDosApertos.php';

class VerificadorDeItensPorCabina {

	// TODO Criar constantes para as posições dos apertos
	public function verificar(Cabina $cabina) {
		return $this->verificarCruzeta($cabina);
	}

	private function verificarCruzeta(Cabina $cabina) {
		if($cabina->isAccelo())
			return $this->verificarCaboMassa($cabina);
		if($cabina->isAtron() && $cabina->getPais() !== Constantes::BRASIL)
			return $this->verificarCaboMassa($cabina);
		
		$posicaoNoArray = 0; // Posição do aperto da cruzeta no array de confirmações
		$cabina->getItemDeVerificacao()->setCruzeta($this->confirmar($cabina, $posicaoNoArray));
		return $this->verificarCaboMassa($cabina);
	}

	private function verificarCaboMassa(Cabina $cabina) {
		if($cabina->isNTC()) {
			$posicaoNoArray = 1; // Posição do aperto do cabo massa no array de confirmações
			$cabina->getItemDeVerificacao()->setCaboMassa($this->confirmar($cabina, $posicaoNoArray));
		}
		return $this->verificarValvulaNTC($cabina);
	}

	private function verificarValvulaNTC(Cabina $cabina) {
		if($cabina->isNTC()) {
			$posicaoNoArray = 2; // Posição do aperto da válvula da pedaleira NTC no array de confirmações
			$cabina->getItemDeVerificacao()->setValvulaNTC($this->confirmar($cabina, $posicaoNoArray));
		}
		return $this->verificarValvulaNoSuporte($cabina);
	}

	private function verificarValvulaNoSuporte(Cabina $cabina) {
		if($cabina->isAccelo()) {
			$posicaoNoArray = 0;
			$cabina->getItemDeVerificacao()->setValvulaLTC($this->confirmar($cabina, $posicaoNoArray));
		}
		return $this->verificarConsoleNoSuporte($cabina);
	}

	private function verificarConsoleNoSuporte(Cabina $cabina) {
		if($cabina->isAccelo()) {
			$posicaoNoArray = 1;
			$cabina->getItemDeVerificacao()->setConsoleLTC($this->confirmar($cabina, $posicaoNoArray));
		}
		return $this->verificarPedaleiraAxor($cabina);
	}

	private function verificarPedaleiraAxor(Cabina $cabina) {
		if($cabina->isAxor()) {
			$verificacaoDos6Apertos;
			$verificacaoDoReaperto;
			$posicaoDos6ApertosNoArray = 3;
			$posicaoDoReapertoNoArray = 4;
			$verificacaoDos6Apertos = $this->confirmar($cabina, $posicaoDos6ApertosNoArray);
			
			if($verificacaoDos6Apertos === Constantes::CONFIRMACAO)
				$verificacaoDoReaperto = $this->confirmar($cabina, $posicaoDoReapertoNoArray);
			else
				$verificacaoDoReaperto = Constantes::NEGACAO;
			$cabina->getItemDeVerificacao()->setPedaleiraAxor($verificacaoDoReaperto);
		}
		return $this->verificarCilindro($cabina);
	}

	private function verificarCilindro(Cabina $cabina) {
		if($cabina->isAxor()) {
			$posicaoDoApertoNoArray = 5;
			$cabina->getItemDeVerificacao()->setCilindro($this->confirmar($cabina, $posicaoDoApertoNoArray));
		}
		return $this->verificarPreSuspensaoAtego($cabina);
	}

	private function verificarPreSuspensaoAtego(Cabina $cabina) {
		if($cabina->isAtego()) {
			$posicaoDoApertoNoArray = 3;
			$cabina->getItemDeVerificacao()->setPreSuspensao($this->confirmar($cabina, $posicaoDoApertoNoArray));
		}
		return $this->verificarPreSuspensaoAxor($cabina);
	}

	private function verificarPreSuspensaoAxor(Cabina $cabina) {
		$verificacoes = array();
		if($cabina->isAxor()) {
			$posicaoDoApertoLE = 6;
			$posicaoDoApertoLD = 7;
			$posicaoDosApertos150Nm = 8;
			
			array_push($verificacoes, $this->confirmar($cabina, $posicaoDoApertoLE));
			array_push($verificacoes, $this->confirmar($cabina, $posicaoDoApertoLD));
			array_push($verificacoes, $this->confirmar($cabina, $posicaoDosApertos150Nm));
			
			if(!in_array(Constantes::NEGACAO, $verificacoes))
				$cabina->getItemDeVerificacao()->setPreSuspensao(Constantes::CONFIRMACAO);
			else
				$cabina->getItemDeVerificacao()->setPreSuspensao(Constantes::NEGACAO);
		}
		return $this->verificarPreSuspensaoAxorFL6($cabina, $verificacoes);
	}

	/*
	 * Devido a insuficiencia de dados para a implementação do método existe a nescecidade de conferir
	 * manualmente em alguns casos o aperto da suspensão FL6
	 */
	private function verificarPreSuspensaoAxorFL6(Cabina $cabina, $verificacoes) {
		$posicaoDosApertos = 9;
		if($cabina->isAxor()) {
			if($cabina->getConfirmacoesDosApertos()[$posicaoDosApertos] === Constantes::CONFIRMACAO) {
				$cabina->getItemDeVerificacao()->setPreSuspensaoFL6(Constantes::CONFIRMACAO);
				$cabina->getItemDeVerificacao()->setPreSuspensao(Constantes::SEM_APLICACAO);
			}
			if(!in_array(Constantes::CONFIRMACAO, $verificacoes))
				if($cabina->getItemDeVerificacao()->getPreSuspensaoFL6() !== Constantes::CONFIRMACAO)
					$cabina->getItemDeVerificacao()->setPreSuspensaoFL6(Constantes::CONFERIR);
		}
		return $this->verificarSuspensao($cabina);
	}

	private function verificarSuspensao(Cabina $cabina) {
		$verificacoes = array();
		if(!$cabina->isAtron()) {
			$posicoesDosApertos = PosicaoDosApertos::getPosicaoDosApertos($cabina);
			
			for($i = 0; $i < PosicaoDosApertos::QTD_POSICOES_APERTOS_SUSP; $i++)
				array_push($verificacoes, $this->confirmar($cabina, $posicoesDosApertos[$i]));
			
			if(!in_array(Constantes::NEGACAO, $verificacoes))
				$cabina->getItemDeVerificacao()->setSuspensao(Constantes::CONFIRMACAO);
			else
				$cabina->getItemDeVerificacao()->setSuspensao(Constantes::NEGACAO);
		}
		return $this->verificarSuspensaoAxorFL6($cabina, $verificacoes);
	}

	// TODO Estudar utilizar o algoritimo deste método para as verificações de apertos de suspensão
	private function verificarSuspensaoAxorFL6(Cabina $cabina, array $verificacoes) {
		if($cabina->isAxor() && !in_array(Constantes::CONFIRMACAO, $verificacoes)) {
			$posicaoDosApertos = array_slice($cabina->getConfirmacoesDosApertos(), 10, 4);
			$confirmacoes = array();
			$confirmacoes = array_keys($posicaoDosApertos, Constantes::CONFIRMACAO);
			$qtdConfirmacoes = count($confirmacoes);
			
			if($qtdConfirmacoes === 4)
				$cabina->getItemDeVerificacao()->setSuspensao(Constantes::CONFIRMACAO);
			else if($qtdConfirmacoes < 4 && $qtdConfirmacoes > 0)
				$cabina->getItemDeVerificacao()->setSuspensao(Constantes::NEGACAO);
			else
				$cabina->getItemDeVerificacao()->setSuspensao(Constantes::CONFERIR);
		}
		return $this->verificarPedalAtron($cabina);
	}

	private function verificarPedalAtron(Cabina $cabina) {
		if($cabina->isAtron()) {
			$posicaoDoApertoNoArray = 1;
			$cabina->getItemDeVerificacao()->setPedalAtron($this->confirmar($cabina, $posicaoDoApertoNoArray));
		}
		return $cabina;
	}

	private function confirmar(Cabina $cabina, $posicaoNoArray) {
		$confirmacoes = $cabina->getConfirmacoesDosApertos();
		if($confirmacoes[$posicaoNoArray] === Constantes::CONFIRMACAO)
			return Constantes::CONFIRMACAO;
		return Constantes::NEGACAO;
	}
} 