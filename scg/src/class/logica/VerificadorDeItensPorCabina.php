<?php

/**
 * Verifica os itens de conferência de acordo com as verificações feitas aperto por aperto pela classe
 * ConferenteDeRegistrosDeAperto.
 */
class VerificadorDeItensPorCabina {

	public function verificar(Cabina $cabina) {
		return $this->verificarCruzeta($cabina);
	}

	private function verificarCruzeta(Cabina $cabina) {
		if($cabina->isAccelo())
			return $this->verificarCaboMassa($cabina);
		if($cabina->isAtron() && $cabina->getPais() !== Pais::BRASIL)
			return $this->verificarCaboMassa($cabina);
		
		$cabina->getItemDeVerificacao()->setCruzeta($this->confirmar($cabina, Apertos::POSICAO_CRUZETA));
		return $this->verificarCaboMassa($cabina);
	}

	private function verificarCaboMassa(Cabina $cabina) {
		if($cabina->isNTC())
			$cabina->getItemDeVerificacao()->setCaboMassa($this->confirmar($cabina, Apertos::POSICAO_CABO_MASSA));
		return $this->verificarValvulaNTC($cabina);
	}

	private function verificarValvulaNTC(Cabina $cabina) {
		if($cabina->isNTC())
			$cabina->getItemDeVerificacao()->setValvulaNTC($this->confirmar($cabina, Apertos::POSICAO_VALVULA_NTC));
		return $this->verificarValvulaNoSuporte($cabina);
	}

	private function verificarValvulaNoSuporte(Cabina $cabina) {
		if($cabina->isAccelo())
			$cabina->getItemDeVerificacao()->setValvulaLTC(
														$this->confirmar($cabina, Apertos::POSICAO_VALVULA_SUPORTE));
		return $this->verificarConsoleNoSuporte($cabina);
	}

	private function verificarConsoleNoSuporte(Cabina $cabina) {
		if($cabina->isAccelo())
			$cabina->getItemDeVerificacao()->setConsoleLTC(
														$this->confirmar($cabina, Apertos::POSICAO_CONSOLE_SUPORTE));
		return $this->verificarPedaleiraAxor($cabina);
	}

	private function verificarPedaleiraAxor(Cabina $cabina) {
		if($cabina->isAxor()) {
			$verificacaoDoReaperto;
			$verificacaoDos6ApertosDaPedaleira = $this->confirmar($cabina, Apertos::POSICAO_PEDALEIRA_AXOR);
			
			if($verificacaoDos6ApertosDaPedaleira === Anotacao::CONFIRMACAO)
				$verificacaoDoReaperto = $this->confirmar($cabina, Apertos::POSICAO_REAPERTO_PEDAL_AXOR);
			else
				$verificacaoDoReaperto = Anotacao::NEGACAO;
			$cabina->getItemDeVerificacao()->setPedaleiraAxor($verificacaoDoReaperto);
		}
		return $this->verificarCilindro($cabina);
	}

	private function verificarCilindro(Cabina $cabina) {
		if($cabina->isAxor())
			$cabina->getItemDeVerificacao()->setCilindro($this->confirmar($cabina, Apertos::POSICAO_CILINDRO));
		return $this->verificarPreSuspensaoAtego($cabina);
	}

	private function verificarPreSuspensaoAtego(Cabina $cabina) {
		if($cabina->isAtego())
			$cabina->getItemDeVerificacao()->setPreSuspensao(
															$this->confirmar($cabina,
																			Apertos::POSICAO_PRE_SUSP_ATEGO));
		return $this->verificarPreSuspensaoAxor($cabina);
	}

	private function verificarPreSuspensaoAxor(Cabina $cabina) {
		$verificacoes = array();
		if($cabina->isAxor()) {
			array_push($verificacoes, $this->confirmar($cabina, Apertos::POSICAO_PRE_LE_AXOR));
			array_push($verificacoes, $this->confirmar($cabina, Apertos::POSICAO_PRE_LD_AXOR));
			array_push($verificacoes, $this->confirmar($cabina, Apertos::POSICAO_PRE_150NM_AXOR));
			// Se houver algum tipo de aperto não confirmado no array a conferência do item deve ser NOK
			if(!in_array(Anotacao::NEGACAO, $verificacoes))
				$cabina->getItemDeVerificacao()->setPreSuspensao(Anotacao::CONFIRMACAO);
			else
				$cabina->getItemDeVerificacao()->setPreSuspensao(Anotacao::NEGACAO);
		}
		return $this->verificarPreSuspensaoAxorFL6($cabina, $verificacoes);
	}

	/*
	 * Devido a insuficiencia de dados para a implementação do método existe a nescecidade de conferir
	 * manualmente em alguns casos o aperto da suspensão FL6
	 */
	private function verificarPreSuspensaoAxorFL6(Cabina $cabina, $verificacoes) {
		if($cabina->isAxor()) {
			if($cabina->getConfirmacoesDosApertos()[Apertos::POSICAO_PRE_AXOR_FL6] === Anotacao::CONFIRMACAO) {
				$cabina->getItemDeVerificacao()->setPreSuspensaoFL6(Anotacao::CONFIRMACAO);
				$cabina->getItemDeVerificacao()->setPreSuspensao(Anotacao::SEM_APLICACAO);
			}
			if(!in_array(Anotacao::CONFIRMACAO, $verificacoes))
				if($cabina->getItemDeVerificacao()->getPreSuspensaoFL6() !== Anotacao::CONFIRMACAO)
					$cabina->getItemDeVerificacao()->setPreSuspensaoFL6(Anotacao::CONFERIR);
		}
		return $this->verificarSuspensao($cabina);
	}

	/**
	 * Extrai das confirmações dos apertos da cabina um array somente com as posições dos apertos de suspensão
	 * e gera ou novo array com as confirmações para cada aperto.
	 * Se o array não conter apertos que estão como NOK confirma o item.
	 */
	private function verificarSuspensao(Cabina $cabina) {
		$verificacoes = array();
		if(!$cabina->isAtron()) {
			$rangeDeApertos = Apertos::getRangeDeApertos($cabina);
			
			for($i = 0; $i < Apertos::QTD_TIPOS_SUSPENSAO; $i++)
				array_push($verificacoes, $this->confirmar($cabina, $rangeDeApertos[$i]));
			
			if(!in_array(Anotacao::NEGACAO, $verificacoes))
				$cabina->getItemDeVerificacao()->setSuspensao(Anotacao::CONFIRMACAO);
			else
				$cabina->getItemDeVerificacao()->setSuspensao(Anotacao::NEGACAO);
		}
		return $this->verificarSuspensaoAxorFL6($cabina, $verificacoes);
	}

	/**
	 * Utiliza a mesma lógica do método @see verificarSuspensao
	 */
	private function verificarSuspensaoAxorFL6(Cabina $cabina, array $verificacoes) {
		if($cabina->isAxor() && !in_array(Anotacao::CONFIRMACAO, $verificacoes)) {
			$posicaoInicial = Apertos::POSICAO_INICIAL_ARRAY_SUSP_AXOR_FL6;
			$qtdApertos = Apertos::QTD_TIPOS_SUSPENSAO;
			$rangeDeApertos = array_slice($cabina->getConfirmacoesDosApertos(), $posicaoInicial, $qtdApertos);
			$confirmacoes = array();
			$confirmacoes = array_keys($rangeDeApertos, Anotacao::CONFIRMACAO);
			$qtdConfirmacoes = count($confirmacoes);
			
			if($qtdConfirmacoes === $qtdApertos)
				$cabina->getItemDeVerificacao()->setSuspensao(Anotacao::CONFIRMACAO);
			else if($qtdConfirmacoes < $qtdApertos && $qtdConfirmacoes > 0)
				$cabina->getItemDeVerificacao()->setSuspensao(Anotacao::NEGACAO);
			else
				$cabina->getItemDeVerificacao()->setSuspensao(Anotacao::CONFERIR);
		}
		return $this->verificarPedalAtron($cabina);
	}

	private function verificarPedalAtron(Cabina $cabina) {
		if($cabina->isAtron())
			$cabina->getItemDeVerificacao()->setPedalAtron($this->confirmar($cabina, Apertos::POSICAO_PEDAL_ATRON));
		return $cabina;
	}

	private function confirmar(Cabina $cabina, $posicaoNoArray) {
		$confirmacoes = $cabina->getConfirmacoesDosApertos();
		if($confirmacoes[$posicaoNoArray] === Anotacao::CONFIRMACAO)
			return Anotacao::CONFIRMACAO;
		return Anotacao::NEGACAO;
	}
} 