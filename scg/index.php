<?php
require_once 'class/GeradorDeListaDeCabinas.php';
require_once 'class/GeradorDeListaDeRegistroDeApertos.php';
require_once 'class/RegistroDeAperto.php';
require_once 'class/TipoDeApertoDAO.php';
require_once 'class/ItemDeVerificacao.php';
require_once 'class/ConferenteDeRegistrosDeAperto.php';
require_once 'src/conecta.php';

$listaDeCabinas = GeradorDeListaDeCabinas::gerar();

$listaDeRegistrosDeAperto = GeradorDeListaDeRegistroDeApertos::gerar();

$tiposDeApertoDAO = new TipoDeApertoDAO($conexao);

$tiposDeAperto = $tiposDeApertoDAO->listarTiposDeApertoComBaumuster();

$conferente = new ConferenteDeRegistrosDeAperto($listaDeCabinas, $listaDeRegistrosDeAperto, $tiposDeAperto);
$conferente->conferir();

