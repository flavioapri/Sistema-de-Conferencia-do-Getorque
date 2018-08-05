<?php

class Conexao {
	private $conexao;

	function __construct() {
		$this->conexao = mysqli_connect("localhost", "root", "", "scg");
	}

	function getConexao() {
		return $this->conexao;
	}
}