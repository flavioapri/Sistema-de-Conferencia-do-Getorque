<?php
class RegistroDeAperto {
	private $nome;
	private $processo;
	private $status;
	private $identificador;

	function __construct($nome, $processo, $status, $identificador) {
		$this->nome = trim($nome);
		$this->processo = trim($processo);
		$this->status = trim($status);
		$this->identificador = trim($identificador);
	}

	function __toString() {
		return $this->nome . "\t" . $this->processo . "\t" . $this->status . "\t" . $this->identificador;
	}

	public function getNome() {
		return $this->nome;
	}

	public function getProcesso() {
		return $this->processo;
	}

	public function getStatus() {
		return $this->status;
	}

	public function getIdentificador() {
		return $this->identificador;
	}
}