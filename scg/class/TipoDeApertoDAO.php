<?php
require_once 'class/TipoDeAperto.php';
class TipoDeApertoDAO {
	private $conexao;

	function __construct($conexao) {
		$this->conexao = $conexao;
	}

// 	function listarTiposDeAperto() {
// 		$tiposDeAperto = array();
// 		$resultado = mysqli_query($this->conexao, "select * from tipos_aperto");
// 		while($tipos_array = mysqli_fetch_array($resultado)) {
// 			$tipoDeAperto = new TipoDeAperto($tipos_array['nome'], $tipos_array['processo'], $tipos_array['qtd_apertos']);
// 			array_push($tiposDeAperto, $tipoDeAperto);
// 		}
// 		return $tiposDeAperto;
// 	}

	function listarTiposDeApertoComBaumuster() {
		$tiposDeAperto = array();
		$resultado = mysqli_query($this->conexao, 
				"select * from tipos_aperto inner join tipos_por_veiculo on tipos_aperto.id = tipos_por_veiculo.tipos_aperto_id
				 inner join baumuster on baumuster.id = tipos_por_veiculo.baumuster_id");
		while($tipos_array = mysqli_fetch_array($resultado)) {
			$tipoDeAperto = new TipoDeAperto($tipos_array['nome'], $tipos_array['processo'], $tipos_array['qtd_apertos'], 
					$tipos_array['codigo']);
			array_push($tiposDeAperto, $tipoDeAperto);
		}
		return $tiposDeAperto;
	}
}