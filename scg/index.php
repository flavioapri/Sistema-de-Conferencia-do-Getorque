<?php
require_once 'src/class/logica/GeradorDeListaDeCabinas.php';
require_once 'src/class/logica/GeradorDeListaDeRegistroDeApertos.php';
require_once 'src/class/modelo/RegistroDeAperto.php';
require_once 'src/class/dao/TipoDeApertoDAO.php';
require_once 'src/class/modelo/ItemDeVerificacao.php';
require_once 'src/class/logica/ConferenteDeRegistrosDeAperto.php';
require_once 'src/conecta.php';

$listaDeCabinas = GeradorDeListaDeCabinas::gerar();

$listaDeRegistrosDeAperto = GeradorDeListaDeRegistroDeApertos::gerar();

$tiposDeApertoDAO = new TipoDeApertoDAO($conexao);

$tiposDeAperto = $tiposDeApertoDAO->listarTiposDeApertoComBaumuster();

$conferente = new ConferenteDeRegistrosDeAperto();

$conferente->conferir($listaDeCabinas, $listaDeRegistrosDeAperto, $tiposDeAperto);

