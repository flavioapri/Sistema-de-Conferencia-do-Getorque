<?php

class ItemDeVerificacao {
	private $cruzeta;
	private $caboMassa;
	private $valvulaNTC;
	private $valvulaLTC;
	private $consoleLTC;
	private $pedaleiraAxor;
	private $cilindro;
	private $preSuspensao;
	private $preSuspensaoFL6;
	private $suspensao;
	private $pedalAtron;
	private $ocorrencia;

	function __construct() {
		$this->cruzeta = "N/A";
		$this->caboMassa = "N/A";
		$this->valvulaNTC = "N/A";
		$this->valvulaLTC = "N/A";
		$this->consoleLTC = "N/A";
		$this->pedaleiraAxor = "N/A";
		$this->cilindro = "N/A";
		$this->preSuspensao = "N/A";
		$this->preSuspensaoFL6 = "N/A";
		$this->suspensao = "N/A";
		$this->pedalAtron = "N/A";
		$this->pedalAtron = "N/A";
	}

	public function imprimir($baumuster) {
		if($baumuster === Baumuster::ATRON)
			return $this->cruzeta . "\t" . $this->pedalAtron;
		return $this->cruzeta . "\t" . $this->caboMassa . "\t" . $this->valvulaNTC . "\t" . $this->valvulaLTC . "\t" .
			$this->consoleLTC . "\t" . $this->pedaleiraAxor . "\t" . $this->cilindro . "\t" . $this->preSuspensao .
			"\t" . $this->preSuspensaoFL6 . "\t" . $this->suspensao;
		// TODO Printar ocorrencia também.
	}

	public function setCruzeta($cruzeta) {
		$this->cruzeta = $cruzeta;
	}

	public function setCaboMassa($caboMassa) {
		$this->caboMassa = $caboMassa;
	}

	public function setValvulaNTC($valvulaNTC) {
		$this->valvulaNTC = $valvulaNTC;
	}

	public function setValvulaLTC($valvulaLTC) {
		$this->valvulaLTC = $valvulaLTC;
	}

	public function setConsoleLTC($consoleLTC) {
		$this->consoleLTC = $consoleLTC;
	}

	public function setPedaleiraAxor($pedaleiraAxor) {
		$this->pedaleiraAxor = $pedaleiraAxor;
	}

	public function setCilindro($cilindro) {
		$this->cilindro = $cilindro;
	}

	public function setPreSuspensao($preSuspensao) {
		$this->preSuspensao = $preSuspensao;
	}

	public function setPreSuspensaoFL6($preSuspensaoFL6) {
		$this->preSuspensaoFL6 = $preSuspensaoFL6;
	}

	public function setSuspensao($suspensao) {
		$this->suspensao = $suspensao;
	}

	public function setPedalAtron($pedalAtron) {
		$this->pedalAtron = $pedalAtron;
	}

	public function setOcorrencia($ocorrencia) {
		$this->ocorrencia = $ocorrencia;
	}

	public function getCruzeta() {
		return $this->cruzeta;
	}

	public function getCaboMassa() {
		return $this->caboMassa;
	}

	public function getValvulaNTC() {
		return $this->valvulaNTC;
	}

	public function getValvulaLTC() {
		return $this->valvulaLTC;
	}

	public function getConsoleLTC() {
		return $this->consoleLTC;
	}

	public function getPedaleiraAxor() {
		return $this->pedaleiraAxor;
	}

	public function getCilindro() {
		return $this->cilindro;
	}

	public function getPreSuspensao() {
		return $this->preSuspensao;
	}

	public function getPreSuspensaoFL6() {
		return $this->preSuspensaoFL6;
	}

	public function getSuspensao() {
		return $this->suspensao;
	}

	public function getPedalAtron() {
		return $this->pedalAtron;
	}

	public function getOcorrencia() {
		return substr_replace($this->ocorrencia, '', -2);
	}
}