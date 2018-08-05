<?php
class TipoDeAperto {
	private $nome;
	private $processo;
	private $qtdApertos;
	private $baumuster;
	
	function __construct($nome, $processo, $qtdApertos, $baumuster) {
		$this->nome = trim(utf8_encode($nome));
		$this->processo = trim(utf8_encode($processo));
		$this->qtdApertos = utf8_encode($qtdApertos);
		$this->baumuster = trim(utf8_encode($baumuster));
	}

	public function getProcesso() {
		return $this->processo;
	}

	public function getNome() {
		return $this->nome;
	}

	public function getQtdApertos() {
		return $this->qtdApertos;
	}

	public function getBaumuster() {
		return $this->baumuster;
	}
}