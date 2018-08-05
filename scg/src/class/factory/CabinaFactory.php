<?php

/**
 * Classe geradora de cabinas para os testes.
 *
 * @author Flavio Aparecido Ribeiro
 *        
 */
class CabinaFactory {
	private $cabina;
	private $confirmacoesDosApertos;

	public function getCabina($baumuster) {
		$this->cabina = new Cabina("﻿", "", "", "", "", "", "", "", "", "", "", "", "", "", "");
		
		$this->cabina->setBaumuster($baumuster);
		$this->confirmacoesDosApertos = $this->geraArrayApertos();
		$this->cabina->setConfirmacoesDosApertos($this->confirmacoesDosApertos);
		
		if(func_get_arg(1) === Code::FL6)
			$this->cabina->setConfirmacoesDosApertos($this->modificarApertosParaFL6());
		
		return $this->cabina;
	}

	private function geraArrayApertos() {
		$confirmacoesDosApertos = array();
		for($i = 0; $i < 18; $i++)
			array_push($confirmacoesDosApertos, Anotacao::CONFIRMACAO);
		return $confirmacoesDosApertos;
	}

	/*
	 * Seta os apertos que não são de cabinas FL6 para NOK, para que a verificação possa ser feita corretamente.
	 */
	private function modificarApertosParaFL6() {
		$posicoesDeApertosNaoFL6 = array(6, 7, 8, 14, 15, 16, 17);
		for($i = 0; $i <= 17; $i++) {
			foreach($posicoesDeApertosNaoFL6 as $posicao) {
				if($i === $posicao)
					$this->confirmacoesDosApertos[$i] = Anotacao::NEGACAO;
			}
		}
		return $this->confirmacoesDosApertos;
	}
}

