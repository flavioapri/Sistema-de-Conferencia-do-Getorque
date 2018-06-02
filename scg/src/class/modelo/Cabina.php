<?php
header("Content-type: text/html; charset=utf-8");
require_once 'src/class/modelo/ItemDeVerificacao.php';
require_once 'src/class/constantes/Constantes.php';

class Cabina {
	private $np;
	private $npFormatado;
	private $semDenominacao1;
	private $baumuster;
	private $varianteVeiculo;
	private $fz;
	private $semDenominacao2;
	private $data;
	private $semDenominacao3;
	private $destino;
	private $pais;
	private $denominacao;
	private $npVeiculo;
	private $semDenominacao4;
	private $cor;
	private $varianteRobauh;
	private $confirmacoesDosApertos;
	private $itemDeVerificacao;

	function __construct($np, $semDenominacao1, $baumuster, $varianteVeiculo, $fz, $semDenominacao2, $data,
						$semDenominacao3, $destino, $pais, $denominacao, $npVeiculo, $semDenominacao4, $cor,
						$varianteRobauh) {
		$this->np = $np;
		$this->npFormatado = trim(preg_replace('#[^0-9]#', '', $np));
		$this->semDenominacao1 = $semDenominacao1;
		$this->baumuster = $baumuster;
		$this->varianteVeiculo = $varianteVeiculo;
		$this->fz = $fz;
		$this->semDenominacao2 = $semDenominacao2;
		$this->data = $data;
		$this->semDenominacao3 = $semDenominacao3;
		$this->destino = $destino;
		$this->pais = trim($pais);
		$this->denominacao = $denominacao;
		$this->npVeiculo = $npVeiculo;
		$this->semDenominacao4 = $semDenominacao4;
		$this->cor = $cor;
		$this->varianteRobauh = $varianteRobauh;
		$this->itemDeVerificacao = new ItemDeVerificacao();
	}

	function __toString() {
		return $this->np . "\t" . $this->baumuster . "\t" . $this->fz . "\t" . $this->pais . "\t" .
			$this->denominacao . "\t" . $this->cor . "\t" . "\n" . "\t" .
			$this->itemDeVerificacao->imprimir($this->baumuster);
	}

	public function getNp() {
		return $this->np;
	}

	public function getNpFormatado() {
		return $this->npFormatado;
	}

	public function getSemDenominacao1() {
		return $this->semDenominacao1;
	}

	public function getBaumuster() {
		return $this->baumuster;
	}

	public function getVarianteVeiculo() {
		return $this->varianteVeiculo;
	}

	public function getFz() {
		return $this->fz;
	}

	public function getSemDenominacao2() {
		return $this->semDenominacao2;
	}

	public function getData() {
		return $this->data;
	}

	public function getSemDenominacao3() {
		return $this->semDenominacao3;
	}

	public function getDestino() {
		return $this->destino;
	}

	public function getPais() {
		return $this->pais;
	}

	public function getDenominacao() {
		return $this->denominacao;
	}

	public function getNpVeiculo() {
		return $this->npVeiculo;
	}

	public function getCor() {
		return $this->cor;
	}

	public function getVarianteRobauh() {
		return $this->varianteRobauh;
	}

	public function getItemDeVerificacao() {
		return $this->itemDeVerificacao;
	}

	public function getConfirmacoesDosApertos() {
		return $this->confirmacoesDosApertos;
	}

	public function setBaumuster($baumuster) {
		$this->baumuster = $baumuster;
	}

	public function isAxor() {
		if($this->baumuster === Constantes::AXOR_C || $this->baumuster === Constantes::AXOR_R)
			return true;
		return false;
	}

	public function isAtego() {
		if($this->baumuster === Constantes::ATEGO)
			return true;
		return false;
	}

	public function isAccelo() {
		if($this->baumuster === Constantes::ACCELO)
			return true;
		return false;
	}

	public function isAtron() {
		if($this->baumuster === Constantes::ATRON)
			return true;
		return false;
	}

	public function isNTC() {
		if(!$this->isAccelo() && !$this->isAtron())
			return true;
		return false;
	}

	public function setConfirmacoesDosApertos($confirmacoesDosApertos) {
		$this->confirmacoesDosApertos = $confirmacoesDosApertos;
	}
	
	public function setVerificacaoDeAperto($posicao, $valor){
		$this->confirmacoesDosApertos[$posicao] = $valor;
	}
}