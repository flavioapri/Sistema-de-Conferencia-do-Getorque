<?php
require_once 'conecta.php';
require_once 'class/TipoDeAperto.php';

function listaTiposDeApertos($conexao) {
	$tiposDeApertos = array();
	$resultado = mysqli_query($conexao, "select * from tipoapertos");
	while ($tipos_array = mysqli_fetch_array($resultado)) {
		$tipoDeAperto = new TipoDeAperto($tipos_array['processo'], $tipos_array['baumuster'], $tipos_array['qtdapertos']); 
		
		array_push($tiposDeApertos, $tipoDeAperto);
	}
	return $tiposDeApertos;
}

